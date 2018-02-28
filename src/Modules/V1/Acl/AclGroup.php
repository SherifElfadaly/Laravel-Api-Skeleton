<?php namespace App\Modules\V1\Acl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AclGroup extends Model{

    use SoftDeletes;
    protected $table    = 'groups';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name'];
    public $searchable  = ['name'];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->addHours(\Session::get('timeZoneDiff'))->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->addHours(\Session::get('timeZoneDiff'))->toDateTimeString();
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->addHours(\Session::get('timeZoneDiff'))->toDateTimeString();
    }

    public function users()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclUser','users_groups','group_id','user_id')->whereNull('users_groups.deleted_at')->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclPermission','groups_permissions','group_id','permission_id')->whereNull('groups_permissions.deleted_at')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\AclGroupObserver'));
    }
}
