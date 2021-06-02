<?php

namespace App\Modules\Core\BaseClasses;

use ReflectionClass;

class BaseEnum
{
    /**
     * Get all constants as an array.
     *
     * @return  array
     */
    public static function all()
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * Get all constants values as an array.
     *
     * @return  array
     */
    public static function values()
    {
        return array_values(self::all());
    }

    /**
     * Get all constants keys as an array.
     *
     * @return  array
     */
    public static function keys()
    {
        return array_keys(self::all());
    }

    /**
     * Get constant key for the given value.
     *
     * @return  mixed
     */
    public static function key($type)
    {
        return collect(self::all())->search($type);
    }

    /**
     * Convert the consts to key: value comma seperated string.
     *
     * @return  string
     */
    public static function toString()
    {
        $stringArr = [];
        collect(self::all())->each(function($item, $key) use (&$stringArr) {
            $stringArr[] = $key . ': ' . $item;
        });

        return implode(',', $stringArr);
    }
}
