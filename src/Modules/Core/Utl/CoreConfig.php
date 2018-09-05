<?php namespace App\Modules\V1\Core\Utl;

class CoreConfig
{
    public function getConfig()
    {
        return [
			/**
			 * Specify what relations should be used for every model.
			 */
			'relations' => config('relations'),
			/**
			 * Specify caching config for each api.
			 */
			'cacheConfig' =>  config('cache_config'),
		];
    }
}