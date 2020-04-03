<?php

namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ApiConsumer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ApiConsumer';
    }
}
