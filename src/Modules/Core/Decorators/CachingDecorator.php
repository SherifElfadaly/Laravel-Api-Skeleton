<?php

namespace App\Modules\Core\Decorators;

use Illuminate\Support\Arr;
use Illuminate\Contracts\Cache\Repository as Cache;

class CachingDecorator
{
    /**
     * @var string
     */
    public $repo;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    public $modelKey;

    /**
     * @var string
     */
    public $model;

    /**
     * @var string
     */
    public $modelClass;

    /**
     * @var mixed
     */
    public $cacheConfig;

    /**
     * @var string
     */
    public $cacheTag;
    
    /**
     * Init new object.
     *
     * @param  string $repo
     * @param  Cache  $cache
     *
     * @return  void
     */
    public function __construct($repo, Cache $cache)
    {
        $this->repo       = $repo;
        $this->cache      = $cache;
        $this->model      = $this->repo->model;
        $this->modelClass = get_class($this->model);
        $repoClass        = explode('\\', get_class($this->repo));
        $repoName         = end($repoClass);
        $this->cacheTag   = lcfirst(substr($repoName, 0, strpos($repoName, 'Repository')));
    }

    /**
     * Handle the cache mechanism for the called method
     * based the configurations.
     *
     * @param  string $name the called method name
     * @param  array  $arguments the method arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
        $this->setCacheConfig($name);

        if ($this->cacheConfig && $this->cacheConfig == 'cache') {
            $page     = \Request::get('page') !== null ? \Request::get('page') : '1';
            $cacheKey = $name.$page.\Session::get('locale').serialize($arguments);
            return $this->cache->tags([$this->cacheTag])->rememberForever($cacheKey, function () use ($arguments, $name) {
                return call_user_func_array([$this->repo, $name], $arguments);
            });
        } elseif ($this->cacheConfig && $this->cacheConfig == 'clear') {
            $this->cache->tags($this->cacheConfig)->flush();
            return call_user_func_array([$this->repo, $name], $arguments);
        }

        return call_user_func_array([$this->repo, $name], $arguments);
    }

    /**
     * Set cache config based on the called method.
     *
     * @param  string $name
     * @return void
     */
    private function setCacheConfig($name)
    {
        $config            = \CoreConfig::getConfig();
        $cacheConfig       = Arr::get($config['cacheConfig'], $this->cacheTag, false);
        $this->cacheConfig = false;

        if ($cacheConfig && in_array($name, $cacheConfig['cache'])) {
            $this->cacheConfig = 'cache';
        } elseif ($cacheConfig && isset($cacheConfig['clear'][$name])) {
            $this->cacheConfig = $cacheConfig['clear'][$name];
        }
    }
}
