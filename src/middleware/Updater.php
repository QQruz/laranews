<?php

namespace QQruz\Laranews;


class Updater
{

    public function handle($request, $next, int $updateEvery, ...$updateList)
    {    
        $requestModel = config('laranews.models.request');
        $updateEvery *= 60;

        if (count($updateList) == 0) {
            $updateList = $requestModel::where('auto_update', true)->get();
        }

        foreach($updateList as $update) {
            
            $model = $update;
            
            if (is_string($update)) {
                $model = is_numeric($update) ? $requestModel::find($update) : $requestModel::where('name' , $update)->first();
            }

            if ($model && time() - strtotime($model->updated_at) >= $updateEvery) {
                resolve('laranews')->update($model);
            }
        }

        return $next($request);
    }
}
