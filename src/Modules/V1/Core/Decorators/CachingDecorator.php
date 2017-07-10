<?php namespace App\Modules\V1\Core\Decorators;

class CachingDecorator
{
    /**
     * The repo implementation.
     * 
     * @var string
     */
    public $repo;

    /**
     * The cache implementation.
     * 
     * @var object
     */
    protected $cache;

    /**
     * The modelClass implementation.
     * 
     * @var string
     */
    public $modelClass;

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
        $this->repo       = $repo;
        $this->cache      = $cache;
        $this->model      = $this->repo->model;
        $this->modelClass = get_class($this->model);
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
            $cacheKey = $name . $page . \Session::get('locale') . serialize($arguments);
            return $this->cache->tags([$this->modelClass])->rememberForever($cacheKey, function() use ($arguments, $name) {
                return call_user_func_array([$this->repo, $name], $arguments);
            });
        }
        else if ($this->cacheConfig)
        {
            $this->cache->tags($this->modelClass)->flush();
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
        $strArr            = explode('\\', get_class($this->repo));
        $repoName          = end($strArr);
        $configKey         = str_plural(strtolower(substr($repoName, 0, strpos($repoName, 'Repository'))));
        
        $config            = \CoreConfig::getConfig();
        $cacheConfig       = array_key_exists($configKey, $config['cacheConfig']) ? $config['cacheConfig'][$configKey] : false;
        $this->cacheConfig = false;

        if ($cacheConfig && in_array($name, $cacheConfig['cache']))
        {
            $this->cacheConfig = 'cache';
        }
        else if ($cacheConfig && in_array($name, $cacheConfig['clear']))
        {
            $this->cacheConfig = $cacheConfig['clear'][$name];
        }
    }
}