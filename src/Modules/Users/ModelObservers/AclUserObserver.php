<?php

namespace App\Modules\Users\ModelObservers;

use App\Modules\Core\Facades\Core;

/**
 * Handling of model events,
 */
class AclUserObserver
{

    public function saving($model)
    {
        if ($model->isDirty('profile_picture')) {
            Core::fileManager()->delete($model->getOriginal('profile_picture'), 'path');
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
                \Core::oauthClients()->revokeAccessToken($token);
            });
        }
    }

    public function deleting($model)
    {
        if ($model->getOriginal('id') == \Auth::id()) {
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
