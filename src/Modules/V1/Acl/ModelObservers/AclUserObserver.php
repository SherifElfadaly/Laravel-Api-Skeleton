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
        if ($model->password) 
        {
            $model->last_change_password = \Carbon\Carbon::now()->toDateTimeString();
        }
    }

    public function updated($model)
    {
        //
    }

    /**
     * Soft delete user logs.
     * 
     * @param  object $model the delted model.
     * @return void
     */
    public function deleting($model)
    {
        if ($model->getOriginal('id') == \Auth::id()) 
        {
            \ErrorHandler::noPermissions();
        }
        $model->logs()->delete();
    }

    public function deleted($model)
    {
        //
    }

    public function restoring($model)
    {
        $model->logs()->restore();
    }

    public function restored($model)
    {
        //
    }
}