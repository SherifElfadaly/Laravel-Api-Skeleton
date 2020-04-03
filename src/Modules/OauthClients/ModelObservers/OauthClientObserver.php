<?php

namespace App\Modules\OauthClients\ModelObservers;

use Illuminate\Support\Str;

/**
 * Handling of model events,
 */
class OauthClientObserver
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
        $model->secret = Str::random(40);
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
