<?php namespace App\Modules\V1\Notifications;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model{

    use SoftDeletes;
    protected $table    = 'notifications';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at', 'item_type', 'data'];
    protected $guarded  = ['id'];
    protected $fillable = ['key', 'data', 'item_name', 'item_type', 'item_id', 'notified'];
    protected $appends  = ['description'];
    public $searchable  = ['key', 'item_name', 'item_type'];

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

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }

    public function getDescriptionAttribute()
    {
        return trans('notifications.' . $this->attributes['key'], unserialize($this->attributes['data']));
    }

    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Notifications\ModelObservers\NotificationObserver'));
    }
}
