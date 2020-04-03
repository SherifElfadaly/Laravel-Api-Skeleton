<?php

namespace App\Modules\Core;

use App\Modules\Core\Interfaces\BaseFactoryInterface;

class Core implements BaseFactoryInterface
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
        foreach (\Module::all() as $module) {
            $nameSpace = 'App\\Modules\\' . $module['basename'] ;
            $model = ucfirst(\Str::singular($name));
            $class = $nameSpace . '\\Repositories\\' . $model . 'Repository';

            if (class_exists($class)) {
                return \App::make($class);
            }
        }
    }
}
