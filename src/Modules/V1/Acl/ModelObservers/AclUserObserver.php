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

    /**
     * Soft delete the associated groups and logs to the deleted user.
     * 
     * @param  object $model the delted model.
     * @return void
     */
    public function deleting($model)
    {
        \DB::table('users_groups')->where('user_id', $model->id)->update(array('deleted_at' => \DB::raw('NOW()')));
        $model->logs()->delete();
    }

    public function deleted($model)
    {
        //
    }

}