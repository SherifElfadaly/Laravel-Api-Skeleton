<?php namespace App\Modules\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model{

    use SoftDeletes;
	protected $table    = 'reports';
	protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
	protected $hidden   = ['deleted_at'];
	protected $guarded  = ['id'];
	protected $fillable = ['report_name', 'view_name'];

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
    }
}
