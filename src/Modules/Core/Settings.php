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
    public $searchable  = ['name', 'value', 'key'];
    
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
    
    public function newCollection(array $models = [])
    {
        return parent::newCollection($models)->keyBy('key');
    }

    public static function boot()
    {
        parent::boot();
        Settings::observe(\App::make('App\Modules\Core\ModelObservers\SettingsObserver'));
    }
}
