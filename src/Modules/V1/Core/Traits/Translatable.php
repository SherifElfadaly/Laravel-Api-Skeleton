<?php namespace App\Modules\V1\Core\Traits;

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

        foreach ($model->attributes AS $key => $value)
        {
            if (isset($this->translatable) && in_array($key, $this->translatable)) 
            {
                $model->$key = $this->getTranslatedAttribute($key, $value);
            }
        }

        return $model;
    }

    /**
     * Returns a translatable model attribute based on the application's locale settings.
     *
     * @param $key
     * @param $values
     * @return string
     */
    protected function getTranslatedAttribute($key, $values)
    {
        $values         = json_decode($values);
        $primaryLocale  = \Session::get(\CoreConfig::getConfig()['var_names']['locale']);
        $fallbackLocale = \CoreConfig::getConfig()['var_names']['locale_fallback'];

        if ($primaryLocale == 'all') 
        {
            return $values;
        }

        if ( ! $primaryLocale || ! isset($values->$primaryLocale)) 
        {
            return $values ? isset($values->$fallbackLocale) ? $values->$fallbackLocale : $values : '';
        }

        return $primaryLocale == 'all' ? $values : $values->$primaryLocale;
    }
}