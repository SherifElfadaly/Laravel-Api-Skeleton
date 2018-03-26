<?php namespace App\Modules\V1\Acl\ModelObservers;

/**
 * Handling of model events,
 */
class AclUserObserver {

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

    public function updating($model)
    {
        //
    }

    public function updated($model)
    {
        //
    }

    public function deleting($model)
    {
        if ($model->getOriginal('id') == \Auth::id()) 
        {
            \ErrorHandler::noPermissions();
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