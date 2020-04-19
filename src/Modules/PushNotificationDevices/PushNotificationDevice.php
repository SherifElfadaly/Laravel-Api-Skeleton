<?php

namespace App\Modules\PushNotificationDevices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Users\AclUser;
use App\Modules\PushNotificationDevices\ModelObservers\PushNotificationDeviceObserver;

class PushNotificationDevice extends Model
{

    use SoftDeletes;
    protected $table    = 'push_notification_devices';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at', 'access_token'];
    protected $guarded  = ['id'];
    protected $fillable = ['device_token', 'user_id', 'access_token'];
    
    public function user()
    {
        return $this->belongsTo(AclUser::class);
    }

    /**
     * Encrypt the access_token attribute before
     * saving it in the storage.
     *
     * @param string $value
     */
    public function setLoginTokenAttribute($value)
    {
        $this->attributes['access_token'] = encrypt($value);
    }

    public static function boot()
    {
        parent::boot();
        PushNotificationDevice::observe(PushNotificationDeviceObserver::class);
    }
}
