<?php namespace App\Modules\Reporting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model{

    use SoftDeletes;
	protected $table    = 'reports';
	protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
	protected $hidden   = ['deleted_at'];
	protected $guarded  = ['id'];
	protected $fillable = ['report_name', 'view_name'];
    public $searchable  = ['report_name', 'view_name'];

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
    
    public static function boot()
    {
        parent::boot();
        $this->observe(\App::make('App\Modules\Reporting\ModelObservers\ReprotObserver'));
    }
}
