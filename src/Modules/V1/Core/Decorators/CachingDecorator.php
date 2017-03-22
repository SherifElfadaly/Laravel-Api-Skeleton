<?php namespace App\Modules\V1\Core\Decorators;

class CachingDecorator
{
    /**
     * The repo implementation.
     * 
     * @var string
     */
    protected $repo;

    /**
     * The cache implementation.
     * 
     * @var object
     */
    protected $cache;

    /**
     * The model implementation.
     * 
     * @var string
     */
    public $model;

    /**
     * The cacheConfig implementation.
     * 
     * @var array
     */
    public $cacheConfig;
    
    /**
     * Create new CachingDecorator instance.
     */
    public function __construct($repo, $cache)
    {   
        $this->repo  = $repo;
        $this->cache = $cache;
        $this->model = get_class($this->repo->model);
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

        if ($this->cacheConfig && $this->cacheConfig == 'cache') 
        {
            $page     = \Request::get('page') ?? '1';
            $cacheKey = $name . $page . serialize($arguments);
            return $this->cache->tags([$this->model])->rememberForever($cacheKey, function() use ($arguments, $name) {
                return call_user_func_array([$this->repo, $name], $arguments);
            });
        }
        else if ($this->cacheConfig)
        {
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
        $cacheConfig       = array_key_exists($this->model, $config['cacheConfig']) ? $config['cacheConfig'][$this->model] : false;
        $this->cacheConfig = false;

        if (in_array($cacheConfig['cache'], $name))
        {
            $this->cacheConfig = 'cache';
        }
        else if (in_array($cacheConfig['clear'], $name))
        {
            $this->cacheConfig = $cacheConfig['clear'][$name];
        }
    }
}