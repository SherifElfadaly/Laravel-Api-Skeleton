<?php

namespace App\Modules\Users;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use App\Modules\Notifications\Notification;
use App\Modules\Roles\Role;
use App\Modules\OauthClients\OauthClient;
use App\Modules\Users\ModelObservers\AclUserObserver;

class AclUser extends User
{
    use SoftDeletes, HasApiTokens;
    protected $table    = 'users';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['password', 'remember_token', 'deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['profile_picture', 'name', 'email', 'password', 'locale', 'timezone'];
    
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

    /**
     * Get the profile picture url.
     * @return string
     */
    public function getProfilePictureAttribute($value)
    {
        return url(\Storage::url($value));
    }

    /**
     * Encrypt the password attribute before
     * saving it in the storage.
     *
     * @param string $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    /**
     * Get the entity's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id')->whereNull('role_user.deleted_at')->withTimestamps();
    }

    public function oauthClients()
    {
        return $this->hasMany(OauthClient::class, 'user_id');
    }

    /**
     * Return fcm device tokens that will be used in sending fcm notifications.
     *
     * @return array
     */
    public function routeNotificationForFCM()
    {
        $devices = \Core::pushNotificationDevices()->findBy(['user_id' => $this->id]);
        $tokens  = [];

        foreach ($devices as $device) {
            if (\Core::oauthClients()->accessTokenExpiredOrRevoked($device->access_token)) {
                $device->forceDelete();
                continue;
            }

            $tokens[] = $device->device_token;
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
        return 'users.'.$this->id;
    }

    /**
     * Custom password validation.
     *
     * @param  string $password
     * @return boolean
     */
    public function validateForPassportPasswordGrant($password)
    {
        if ($password == config('skeleton.social_pass')) {
            return true;
        }

        return \Hash::check($password, $this->password);
    }
    
    public static function boot()
    {
        parent::boot();
        AclUser::observe(AclUserObserver::class);
    }
}
