<?php namespace App\Modules\Acl\ModelObservers;

/**
 * Handling of model events,
 */
class AclPermissionObserver {

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
     * Soft delete the associated groups to the deleted permission.
     * 
     * @param  object $model the delted model.
     * @return void
     */
    public function deleting($model)
    {
        \DB::table('groups_permissions')->where('permission_id', $model->id)->update(array('deleted_at' => \DB::raw('NOW()')));
    }

    public function deleted($model)
    {
        //
    }

}