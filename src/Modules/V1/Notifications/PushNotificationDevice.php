<?php namespace App\Modules\V1\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PushNotificationDevice extends Model{

    use SoftDeletes;
    protected $table    = 'push_notifications_devices';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at', 'access_token'];
    protected $guarded  = ['id'];
    protected $fillable = ['device_token', 'user_id', 'access_token'];
    public $searchable  = ['device_token'];

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
    
    public function user()
    {
        return $this->belongsTo('App\Modules\V1\Acl\AclUser');
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
        parent::observe(\App::make('App\Modules\V1\Notifications\ModelObservers\PushNotificationDeviceObserver'));
    }
}
