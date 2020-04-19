<?php

namespace App\Modules\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Users\AclUser;
use App\Modules\Permissions\Permission;
use App\Modules\Roles\ModelObservers\RoleObserver;

class Role extends Model
{

    use SoftDeletes;
    protected $table    = 'roles';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(AclUser::class, 'role_user', 'role_id', 'user_id')->whereNull('role_user.deleted_at')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id')->whereNull('permission_role.deleted_at')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        Role::observe(RoleObserver::class);
    }
}
