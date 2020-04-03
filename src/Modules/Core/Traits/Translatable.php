<?php

namespace App\Modules\Core\Traits;

trait Translatable
{
    /**
     * Create a new model instance that is existing.
     *
     * @param  array  $attributes
     * @param  string|null  $connection
     * @return static
     */
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        foreach ($model->attributes as $key => $value) {
            if (isset($this->translatable) && in_array($key, $this->translatable)) {
                $model->$key = $this->getTranslatedAttribute($value);
            }
        }

        return $model;
    }

    /**
     * Returns a translatable model attribute based on the application's locale settings.
     *
     * @param $values
     * @return string
     */
    protected function getTranslatedAttribute($values)
    {
        $values         = json_decode($values);
        $primaryLocale  = \Session::get('locale');
        $fallbackLocale = 'en';

        if ($primaryLocale == 'all') {
            return $values;
        }

        if (! $primaryLocale || ! is_object($values) || ! property_exists($values, $primaryLocale)) {
            return $values ? isset($values->$fallbackLocale) ? $values->$fallbackLocale : $values : '';
        }

        return $primaryLocale == 'all' ? $values : $values->$primaryLocale;
    }
}
