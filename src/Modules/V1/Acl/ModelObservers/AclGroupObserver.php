<?php namespace App\Modules\V1\Acl\ModelObservers;

/**
 * Handling of model events,
 */
class AclGroupObserver {

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
     * Prevent updating of the admin group.
     * 
     * @param  object $model the model beign updated.
     * @return void
     */
    public function updating($model)
    {
        if ($model->getOriginal()['name'] == 'Admin') 
        {
            \ErrorHandler::noPermissions();
        }
    }

    public function updated($model)
    {
        //
    }

    /**
     * Soft delete the associated permissions to the deleted group
     * and prevent deleting the admin group.
     * 
     * @param  object $model the delted model.
     * @return void
     */
    public function deleting($model)
    {
        if ($model->getOriginal()['name'] == 'Admin') 
        {
            \ErrorHandler::noPermissions();
        }

        \DB::table('groups_permissions')->where('group_id', $model->id)->update(array('deleted_at' => \DB::raw('NOW()')));
    }

    public function deleted($model)
    {
        //
    }

}