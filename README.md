# Laranews
## News API implementation for laravel

### Instalation
run
```php
composer require qqruz/laranews
```
and add yours news API key to laravel's .env file
```
NEWS_API_KEY=yourapikey
```

### Usage
```php
// get articles
$articles = Laranews::topHeadlines()
            ->setCategory('general')
            ->setCountry('us')
            ->get()
            ->articles;

// get sources
$sources = Laranews::sources()->get()->sources;

// you can also pass arguments directly to endpoint
$bitcoin = Laranews::everything([
    'q' => 'bitcoin',
    'language' => 'en'
])->get();


```

#### Saving and loading
Laranews comes with eloquent models for saving articles, sources and requests, as well with migrations for them.
To use custom models edit config file.

```php
use QQruz\Laranews\Article;
use QQruz\Laranews\Request;
use QQruz\Laranews\Source;

Laranews::headlines()->setCategory('general')->get()->save('myApiCall');

// load articles
$articles = Article::all()->get();

// load request
$headlinesGeneral = Laranews::load('myApiCall');

// or

$requests = Request::where('endpoint', 'everything')->get();

foreach ($requests as $request) {
    // same as Laranews::load($request)->get()->save();
    Laranews::update($request);
}

```

#### Available methods
**Endpoints**

Sets up parameters for chosen endpoint. One of these methods should be first to call:
```
headlines() / topHeadlines()
```
```
everything()
```
```
sources()
```
```php
// sets up for top-headlines endpoint
Laranews::headlines();
```

**Set URL parameters**
Sets URL parameters for API call. Check news api's documentation for more info.
```
set{$property}($value) 
```
```php
// sets up for sources endpoint, entertainment only, from Serbia
$sources = Laranews::sources()->setCategory('entertainment')->setCountry('rs');
```

**Get URL parameters**
```
get{$property}($value)
```
```php
$country = $news->getCountry() // returns Serbia
```

**Fetching the results**
```
get()
```
```php
// sources
$sources->get();
$sources = $news->sources;

//articles
$articles = $articles->get()->articles;
```

**Saving**
Saves request and results
```
// optional name is for identifing the request
// if not provided it will be auto generated $endpoint + time()
save($name)
```
Saves articles + sources
```
saveResults()
```
Saves request only
```
saveRequest($name)
```
Saves articles only
```
saveArticles()
```
Saves sources only
```
saveSources()
```
```php
// only articles will be saved
// results from sources endpoint will be ignored
Laranews::everything()->setQInTitle('laravel')->get()
        ->sources()->get()->saveArticles();
```

**Loading**
Loads the request from saved model.
If string is provided it will look for a model with that name.
If integer is provided it will look for a model with that Id.
```
load($request)
```
```php
use QQruz\Laranews\Request;

$request = Request::where('name', 'someName');
$news = Laranews::load($request)

// or

$news = Laranews::load('someName');

// or

$news = Laranews::load(1);

// additionally you can load request from custom model
$news = Laranews::fromModel(Some\Model\Name)
```

#### Auto updating
Laranews comes with two ways of auto updating
1. Middleware
2. Scheduling

To enable auto updating on your saved requests you need to call:
```
auto() or autoUpdate()
```
```php
Laranews::topHeadlines([
    'category' => 'health'
])->autoUpdate()->saveRequest('doctors');
```

**Middleware**
You can add update trigger to specific route or group.
Argument passed represents minimum time between the updates, so you can save api calls.
```php
Route::get('/', function () {
    // update every 15 minutes all requests with auto_update flag
})->middleware('laranews:15');
```
Second, optional argument can be passed to specify which request(s) should be run.
Note that only specified requests will run, and rest will be ignored.
```php
Route::get('/news/business', function () {
    // update every 15 minutes request with ID 4
})->middleware('laranews:15,4');


Route::get('/news/health', function () {
    // update every 15 minutes request named doctors
})->middleware('laranews:15,doctors');


Route::get('/news/business_doctors', function () {
    // updates both every 30 min
})->middleware('laranews:30,doctors,4');
``` 

**Scheduler**
For now you can use scheduler only to update all flaged requests.
To enable scheduler you need to edit config file first
```php
'schedule' => [
    'enabled' => true,
    'method' => 'everyFifteenMinutes',
    'params' => null
]
```
For available methods and params please go to https://laravel.com/docs/5.8/scheduling#schedule-frequency-options

#### GUI
GUI is still in works, and it's not recommended to use it in production, but it can get you going.
It consist of two bootstrap themed files:
1. laranews::builder - form for creating new request
2. laranews::listing - listing and editing of save requests

To make these forms work you will need to edit config file.
