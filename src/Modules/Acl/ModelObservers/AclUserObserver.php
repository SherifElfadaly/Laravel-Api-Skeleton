<?php namespace App\Modules\Acl\ModelObservers;

/**
 * Handling of model events,
 */
class AclUserObserver
{

    public function saving($model)
    {
        if ($model->isDirty('profile_picture')) {
            \Media::deleteImage($model->getOriginal('profile_picture'));
        }
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
        if ($model->isDirty('blocked') && $model->blocked) {
            $model->tokens()->each(function ($token) {

                \Core::users()->revokeAccessToken($token);
            });
        }
    }

    public function deleting($model)
    {
        if ($model->getOriginal('id') == \Auth::id()) {
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
