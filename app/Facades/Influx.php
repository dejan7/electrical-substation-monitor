<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Influx extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'influx';
    }
}