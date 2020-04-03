<?php

namespace App\Modules\Core\ModelObservers;

/**
 * Handling of model events,
 */
class SettingsObserver
{

    public function saving($model)
    {
        //
    }

    public function saved($model)
    {
        //
    }

    /**
     * Prevent the creating of the settings.
     *
     * @param  object $model the model beign created.
     * @return void
     */
    public function creating($model)
    {
        \Errors::cannotCreateSetting();
    }

    public function created($model)
    {
        //
    }

    /**
     * Prevent updating of the setting key.
     *
     * @param  object $model the model beign updated.
     * @return void
     */
    public function updating($model)
    {
        if ($model->getOriginal('key') !== $model->key) {
            \Errors::cannotUpdateSettingKey();
        }
    }

    public function updated($model)
    {
        //
    }

    public function deleting($model)
    {
        //
    }

    public function deleted($model)
    {
        //
    }

    public function restoring($model)
    {
        //
    }

    public function restored($model)
    {
        //
    }
}
