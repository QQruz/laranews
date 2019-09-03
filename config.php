<?php 
return [
    // your news api key
    'apiKey' => env('NEWS_API_KEY', ''),

    'models' => [
        'article' => 'QQruz\Laranews\Article',
        'source' => 'QQruz\Laranews\Source',
        'request' => 'QQruz\Laranews\Request'
    ],

    'tables' => [
        'article' => 'laranews_articles',
        'source' => 'laranews_source',
        'request' => 'laranews_requests'
    ],

    // routes for forms
    'routes' => [
        'store' => url('/store'),
        'update' => url('/update'),
        'delete' => url('/delete')
    ],

    // registers schedule
    // for more info about available methods:
    // https://laravel.com/docs/5.8/scheduling#schedule-frequency-options
    'schedule' => [
        'enabled' => false,
        'method' => 'everyFifteenMinutes',
        'params' => null
    ]

];