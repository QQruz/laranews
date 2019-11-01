<?php

namespace QQruz\Laranews;

use Illuminate\Support\ServiceProvider;


class LaranewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(
            __DIR__. '/../config.php', 'laranews'
        );   

        $this->app->bind('newsapi', function ($app) {
            return new Newsapi(config('laranews.apiKey'));
        });

        $this->app->bind('laranews', function ($app) {
            return new Laranews(config('laranews.apiKey'));
        });


        app('router')->aliasMiddleware('laranews', Updater::class);

        if (config('laranews.schedule.enabled') === true) {
            $this->registerSchedule();
        }

        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laranews');

        // $this->publishes([
        //     __DIR__ . '/../config.php' => config_path('laranews.php'),
        // ], 'config');

        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__. '/resources/views/' => resource_path('views/qqruz/laranews')
        ], 'views');

        $this->publishes([
            __DIR__. 'models/' => app_path()
        ], 'models');

        
    }

    public function registerSchedule() {
        $this->app->booted(function () {

            $model = config('laranews.models.request');
            $updateEvery = config('laranews.schedule.method');
            $params = config('laranews.schedule.params');

            $schedule = $this->app->make(Schedule::class);
            $updates = $model::where('auto_update', true)->get();
            
            $schedule->call(function () {
                foreach($updates as $update) {
                    Laranews::update($update);
                }
            })->{$updateEvery}($params);
        });
    }
}
