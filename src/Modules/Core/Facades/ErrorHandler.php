<?php namespace App\Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ErrorHandler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ErrorHandler';
    }
}
