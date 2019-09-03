<?php

namespace QQruz\Laranews\Facades;


use \Illuminate\Support\Facades\Facade;


class LaranewsFacade extends Facade {
    protected static function getFacadeAccessor() { return 'laranews'; }
}