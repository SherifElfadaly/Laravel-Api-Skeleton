<?php

namespace App\Modules\Core;

use App\Modules\Core\BaseClasses\Contracts\BaseFactoryInterface;
use Caffeinated\Modules\Facades\Module;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use stdClass;

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
    public function __call(string $name, array $arguments): object
    {
        foreach (Module::all() as $module) {
            $nameSpace = 'App\\Modules\\' . $module['basename'];
            $model = ucfirst(Str::singular($name));
            if (count($arguments) == 1 && $arguments[0]) {
                $class = $nameSpace . '\\Services\\' . $model . 'Service';
            } else {
                $class = $nameSpace . '\\Repositories\\' . $model . 'Repository';
            }

            if (class_exists($class)) {
                return App::make($class);
            }
        }

        return new stdClass;
    }
}
