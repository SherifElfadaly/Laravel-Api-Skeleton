<?php namespace App\Modules\Groups\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Groups\AclGroup;

class GroupRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   AclGroup $model
     * @return  void
     */
    public function __construct(AclGroup $model)
    {
        parent::__construct($model);
    }

    /**
     * Assign the given permission ids to the given group.
     *
     * @param  integer $groupId
     * @param  array   $permissionIds
     * @return object
     */
    public function assignPermissions($groupId, $permissionIds)
    {
        \DB::transaction(function () use ($groupId, $permissionIds) {
            $group = $this->find($groupId);
            $group->permissions()->detach();
            $group->permissions()->attach($permissionIds);
        });

        return $this->find($groupId);
    }
}
