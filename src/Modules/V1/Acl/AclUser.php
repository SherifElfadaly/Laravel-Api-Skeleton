<?php namespace App\Modules\V1\Acl;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class AclUser extends User {

    use SoftDeletes, HasApiTokens;
    protected $table    = 'users';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['password', 'remember_token','deleted_at', 'two_factor_code'];
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

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany('\App\Modules\V1\Notifications\Notification', 'notifiable')->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's read notifications.
     */
    public function readNotifications()
    {
        return $this->notifications()->whereNotNull('read_at');
    }

    /**
     * Get the entity's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function groups()
    {
        return $this->belongsToMany('\App\Modules\V1\Acl\AclGroup','users_groups','user_id','group_id')->whereNull('users_groups.deleted_at')->withTimestamps();
    }

    public function oauthClients()
    {
        return $this->hasMany('App\Modules\V1\Acl\OauthClient', 'user_id');
    }

    /**
     * Return fcm device tokens that will be used in sending fcm notifications.
     * 
     * @return array
     */
    public function routeNotificationForFCM()
    {
        $devices = \Core::pushNotificationsDevices()->findBy(['user_id' => $this->id]);
        $tokens  = [];

        foreach ($devices as $device) 
        {
            $accessToken = decrypt($device->access_token);

            try
            {
                if (\Core::users()->accessTokenExpiredOrRevoked($accessToken)) 
                {
                    continue;
                }

                $tokens[] = $device->device_token;
            } 
            catch (\Exception $e) 
            {
                $device->forceDelete();
            }
        }

        return $tokens;
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }
    
    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\AclUserObserver'));
    }
}
