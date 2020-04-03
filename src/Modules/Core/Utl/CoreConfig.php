<?php

namespace App\Modules\Core\Utl;

class CoreConfig
{
    public function getConfig()
    {
        return [
            /**
             * Specify what relations should be used for every model.
             */
            'relations' => config('skeleton.relations'),
            /**
             * Specify caching config for each api.
             */
            'cacheConfig' =>  config('skeleton.cache_config'),
        ];
    }
}
