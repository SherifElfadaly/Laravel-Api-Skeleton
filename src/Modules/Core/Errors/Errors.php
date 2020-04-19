<?php

namespace App\Modules\Core\Errors;

use App\Modules\Core\Interfaces\BaseFactoryInterface;

class Errors implements BaseFactoryInterface
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
            $nameSpace = 'App\\Modules\\' . $module['basename'];
            $class = $nameSpace . '\\Errors\\' . $module['basename'] . 'Errors';

            if (class_exists($class)) {
                $class = \App::make($class);
                if (method_exists($class, $name)) {
                    return call_user_func_array([$class, $name], $arguments);
                }
            }
        }
    }
}
