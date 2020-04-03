<?php

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Errors extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Errors';
    }
}
