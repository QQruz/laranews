<?php

namespace QQruz\Laranews\Facades;


use \Illuminate\Support\Facades\Facade;


class NewsapiFacade extends Facade {
    protected static function getFacadeAccessor() { return 'newsapi'; }
}