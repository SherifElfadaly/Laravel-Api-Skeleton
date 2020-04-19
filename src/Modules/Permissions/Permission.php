<?php

namespace App\Modules\Permissions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Roles\Role;
use App\Modules\Permissions\ModelObservers\PermissionObserver;

class Permission extends Model
{

    use SoftDeletes;
    protected $table    = 'permissions';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name', 'model'];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id')->whereNull('permission_role.deleted_at')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        Permission::observe(PermissionObserver::class);
    }
}
