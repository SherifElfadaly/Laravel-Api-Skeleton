<?php

namespace App\Modules\Core\BaseClasses\Contracts;

interface BaseFactoryInterface
{
    /**
     * @param  string $name the called method name
     * @param  array  $arguments the method arguments
     * @return object
     */
    public function __call(string $name, array $arguments): object;
}
