<?php namespace App\Modules\V1\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model{

    use SoftDeletes;
    protected $table    = 'notifications';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at', 'read_at'];
    protected $hidden   = ['deleted_at', 'notifiable_type', 'notifiable_id', 'data'];
    protected $guarded  = ['id'];
    protected $fillable = ['data', 'type', 'notifiable_type', 'notifiable_id', 'read_at'];
    public $searchable  = [];

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
        parent::observe(\App::make('App\Modules\V1\Notifications\ModelObservers\NotificationObserver'));
    }
}
