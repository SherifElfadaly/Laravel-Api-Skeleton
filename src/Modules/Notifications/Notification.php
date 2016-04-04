<?php namespace App\Modules\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model{

    use SoftDeletes;
    protected $table    = 'notifications';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at', 'item_type'];
    protected $guarded  = ['id'];
    protected $fillable = ['name', 'description', 'item_name', 'item_type', 'item_id', 'notified'];

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
    
    public function item()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\Notifications\ModelObservers\NotificationObserver'));
    }
}
