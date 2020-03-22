<?php namespace App\Modules\Roles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;
    protected $table    = 'roles';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name'];
    public $searchable  = ['name'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->tz(\Session::get('time-zone'))->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->tz(\Session::get('time-zone'))->toDateTimeString();
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->tz(\Session::get('time-zone'))->toDateTimeString();
    }

    public function users()
    {
        return $this->belongsToMany('App\Modules\Users\AclUser', 'users_roles', 'role_id', 'user_id')->whereNull('users_roles.deleted_at')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Modules\Permissions\Permission', 'roles_permissions', 'role_id', 'permission_id')->whereNull('roles_permissions.deleted_at')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        Role::observe(\App::make('App\Modules\Roles\ModelObservers\RoleObserver'));
    }
}
