<?php namespace App\Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settings extends Model{

    use SoftDeletes;
    protected $table    = 'settings';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id', 'key'];
    protected $fillable = ['name','value'];
    
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

    public static function boot()
    {
        parent::boot();

        Settings::creating(function($setting)
        {
            $error = \ErrorHandler::cannotCreateSetting();
            abort($error['status'], $error['message']);
        });

        Settings::updating(function($setting)
        {
            if ($setting->original['key'] !== $setting->key) 
            {
                $error = \ErrorHandler::cannotUpdateSettingKey();
                abort($error['status'], $error['message']);
            }
        });
    }
}
