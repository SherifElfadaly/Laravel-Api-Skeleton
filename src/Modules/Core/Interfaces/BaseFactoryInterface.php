<?php

namespace App\Modules\Core\Interfaces;

interface BaseFactoryInterface
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
    public function __call($name, $arguments);
}
