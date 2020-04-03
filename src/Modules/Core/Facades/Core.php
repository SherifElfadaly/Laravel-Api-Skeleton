<?php

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Core extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Core';
    }
}
