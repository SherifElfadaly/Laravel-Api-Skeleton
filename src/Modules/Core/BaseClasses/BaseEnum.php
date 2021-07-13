<?php

namespace App\Enums;

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
     * Get constant value for the given key.
     *
     * @param string $key
     * @return  array
     */
    public static function value($key)
    {
        return collect(self::all())->get($key);
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
     * @param string $value
     * @return  mixed
     */
    public static function key($value)
    {
        return collect(self::all())->search($value);
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
