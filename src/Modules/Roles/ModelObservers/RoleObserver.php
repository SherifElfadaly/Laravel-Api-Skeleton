<?php

namespace App\Modules\Roles\ModelObservers;

/**
 * Handling of model events,
 */
class RoleObserver
{
    public function saving($model)
    {
        //
    }

    public function saved($model)
    {
        //
    }

    public function creating($model)
    {
        //
    }

    public function created($model)
    {
        //
    }

    /**
     * Prevent updating of the admin role.
     *
     * @param  object $model the model beign updated.
     * @return void
     */
    public function updating($model)
    {
        if ($model->getOriginal('name') == 'Admin') {
            \Errors::noPermissions();
        }
    }

    public function updated($model)
    {
        //
    }

    /**
     * Prevent deleting the admin role.
     *
     * @param  object $model the delted model.
     * @return void
     */
    public function deleting($model)
    {
        if ($model->getOriginal('name') == 'Admin') {
            \Errors::noPermissions();
        }
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
