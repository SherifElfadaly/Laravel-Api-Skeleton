<?php namespace App\Modules\V1\Notifications\ModelObservers;

/**
 * Handling of model events,
 */
class NotificationObserver {

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

    /**
     * Publish the created notification to the redis server 
     * to broadcast it to all listners.
     * 
     * @param  object $model the model beign created.
     * @return void
     */
    public function created($model)
    {
        \Redis::publish('notification', json_encode($model->toArray()));
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

}