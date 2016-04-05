<?php namespace App\Modules\V1\Acl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AclPermission extends Model {

    use SoftDeletes;
    protected $table    = 'permissions';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name', 'model'];

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
    
    public function groups()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclGroup','groups_permissions','permission_id','group_id')->whereNull('groups_permissions.deleted_at')->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\AclPermissionObserver'));
    }
}
