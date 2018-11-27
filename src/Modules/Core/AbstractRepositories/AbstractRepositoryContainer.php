<?php namespace App\Modules\Core\AbstractRepositories;

use App\Modules\Core\Interfaces\RepositoryContainerInterface;

abstract class AbstractRepositoryContainer implements RepositoryContainerInterface
{
	/**
	 * Construct the repository class name based on
	 * the method name called, search in the 
	 * given namespaces for the class and 
	 * return an instance.
	 * 
	 * @param  string $name the called method name
	 * @param  array  $arguments the method arguments
	 * @return object
	 */
	public function __call($name, $arguments)
	{
		foreach ($this->getRepoNameSpace() as $repoNameSpace) 
		{
			$class = rtrim($repoNameSpace, '\\') . '\\' . ucfirst(str_singular($name)) . 'Repository';
			if (class_exists($class)) 
			{
				\App::singleton($class, function ($app) use ($class) {

					return new \App\Modules\Core\Decorators\CachingDecorator(new $class, $app['cache.store']);
				});

				return \App::make($class);
			}
		}
	}

	 /**
	  * Abstract methods that return the necessary 
	  * information (repositories namespaces)
	  * needed to preform the previous actions.
	  * 
	  * @return array
	  */
	abstract protected function getRepoNameSpace();
}