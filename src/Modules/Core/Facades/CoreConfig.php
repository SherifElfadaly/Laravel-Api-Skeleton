<?php

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class CoreConfig extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'CoreConfig';
    }
}
