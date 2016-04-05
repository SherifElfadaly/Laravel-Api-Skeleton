<?php namespace App\Modules\V1\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Logging extends Facade
{
	protected static function getFacadeAccessor() { return 'Logging'; }
}