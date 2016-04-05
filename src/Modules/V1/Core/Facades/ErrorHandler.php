<?php namespace App\Modules\V1\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ErrorHandler extends Facade
{
	protected static function getFacadeAccessor() { return 'ErrorHandler'; }
}