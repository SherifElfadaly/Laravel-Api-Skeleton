<?php namespace App\Modules\V1\Acl;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

class AclUser extends User implements AuthenticatableUserContract {

    use SoftDeletes, Notifiable;
    protected $table    = 'users';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['password', 'remember_token','deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['name', 'email', 'password'];
    public $searchable  = ['name', 'email'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
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

    public function groups()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclGroup','users_groups','user_id','group_id')->whereNull('users_groups.deleted_at')->withTimestamps();
    }

    public function routeNotificationForFCM()
    {
        $devices = \Core::pushNotificationsDevices()->findBy(['user_id' => $this->id]);
        $tokens  = [];

        foreach ($devices as $device) 
        {
            $loginToken = decrypt($device->login_token);

            try
            {
                if (\JWTAuth::authenticate($loginToken)) 
                {
                    $tokens[] = $device->device_token;
                }    
            } 
            catch (\Exception $e) 
            {
                $device->forceDelete();
            }
        }

        return $tokens;
    }
    
    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\AclUserObserver'));
    }
}
