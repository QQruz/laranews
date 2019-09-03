<?php
namespace QQruz\Laranews;

class Laranews extends Newsapi {

    /**
     * error counter
     *
     * @var integer
     */
    private $errorCount = 0;

    /**
     * Name by which request will be saved
     *
     * @var string
     */
    public $requestName;

    /**
     * Used by middleware and scheduler 
     *
     * @var boolean
     */
    public $autoUpdate = false;


    /**
     * Eloquent model for saving requests
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $requestModel;

    /**
     * Eloquent model for saving articles
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $articleModel;

    /**
     * Eloquent model for saving sources
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private $sourceModel;

    /**
     * Constructor
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey) {
        parent::__construct($apiKey);
        
        $this->requestModel = config('laranews.models.request');
        $this->articleModel = config('laranews.models.article');
        $this->sourceModel = config('laranews.models.source');
    }

   /**
    * Save request (api call)
    *
    * @param string (optional) $name
    * @return void
    */
    public function saveRequest(string $name=null) {
        if ($name !== null) {
            $this->requestName = $name;
        }
       
        // if requestName is not set
        // generates new request name based on endpoint and time
        if (!$this->requestName) {
            $this->requestName = $this->endpoint . time();
        }

        // data for saving
        $data = array_merge($this->properties, [
            'endpoint' => $this->endpoint,
            'name' => $this->requestName,
            'auto_update' => $this->autoUpdate,
        ]);
        
        $model = $this->requestModel::updateOrCreate(['name' => $data['name']], $data);
        // force change in updated_at column
        $model->touch();
        
        return $this;
    }

    /**
     * Adds saving error to error array
     *
     * @param string $msg
     * @return Laranews
     */
    private function savingError(string $msg) {
        $this->errorCount++;
        $this->errors['savingError#' . $this->errorCount] = $msg;

        return $this;
    }

    /**
     * Saves articles
     *
     * @return Laranews
     */
    public function saveArticles() {
        foreach ($this->articles as $article) {
            try {
                // format source for mysql
                $article['source_id'] = $article['source']['id'];
                $article['source_name'] = $article['source']['name'];

                $this->articleModel::updateOrCreate(['url' => $article['url']], $article);
            } catch(\Exception $error) {
                $this->savingError($error);
            }
        }
            
        return $this;
    }

    /**
     * Saves sources
     *
     * @return Laranews
     */
    public function saveSources() {
        foreach ($this->sources as $source) {
            try {
                // id here is from fetched results
                // example: abc-news 
                $this->sourceModel::updateOrCreate(['id' => $source['id']], $source);
            } catch(\Exception $error) {
                $this->savingError($error);
            }
        }
        
        return $this;
    }

    /**
     * Saves sources + articles
     *
     * @return Laranews
     */
    public function saveResults() {
        return $this->saveArticles()->saveSources();
    }

    /**
     * Saves sources + articles + request
     *
     * @param string $name name for the request
     * @return Laranews
     */
    public function save(string $name=null) {        
        return $this->saveResults()->saveRequest($name);
    }

    /**
     * Parses request model
     *
     * @param \Illuminate\Database\Eloquent\Model $request
     * @return Laranews
     */
    public function fromModel(\Illuminate\Database\Eloquent\Model $request) {
        // fix for top-headlines endpoint
        $endpoint = str_replace('top-', '', $request->endpoint);
        $this->{$endpoint}();
        
        $properties = array_intersect_key($request->getAttributes(), $this->properties);

        $this->setProperties($properties);

        $this->requestName = $request->name;
        

        return $this;
    }

    /**
     * Parses request model
     * Or if string is passed searches for model by name
     * Or if int is passed searches for model by id
     *
     * @param mixed $request
     * @return Laranews
     */
    public function load($request) {
        if ($request instanceof \Illuminate\Database\Eloquent\Model) {
            $model = $request;
        }

        if (is_string($request)) {
            $model = $this->requestModel::where('name', $request)->first();
        }

        if( is_int($request)) {
            $model = $this->requestModel::find($request);
        }

        return $this->fromModel($model);
    }

    /**
     * Parse model, fetch articles, save everything 
     *
     * @param mixed $request
     * @return Laranews
     */
    public function update($request) {
        return $this->load($request)->get()->save();
    }

    /**
     * Sets autoUpdate
     *
     * @param boolean $update
     * @return Laranews
     */
    public function autoUpdate($update = true) {
        $this->autoUpdate = $update;

        return $this;
    }

    /**
     * Syntatic sugar for autoUpdate
     *
     * @param boolean $update
     * @return Laranews
     */
    public function auto($update = true) {
        return $this->autoUpdate($update);
    }
}