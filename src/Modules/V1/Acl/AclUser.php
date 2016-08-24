<?php namespace App\Modules\V1\Acl;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class AclUser extends User {

    use SoftDeletes;
    protected $table    = 'users';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['password', 'remember_token','deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name', 'email', 'password'];
    public $searchable  = ['name', 'email'];
    
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

    /**
     * Encrypt the password attribute before
     * saving it in the storage.
     * 
     * @param string $value 
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function logs()
    {
        return $this->hasMany('App\Modules\V1\Core\Log', 'user_id');
    }

    public function groups()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclGroup','users_groups','user_id','group_id')->whereNull('users_groups.deleted_at')->withTimestamps();
    }
    
    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\AclUserObserver'));
    }
}
