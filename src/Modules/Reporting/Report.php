<?php

namespace App\Modules\Reporting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Reporting\ModelObservers\ReportObserver;

class Report extends Model
{

    use SoftDeletes;
    protected $table    = 'reports';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = ['report_name', 'view_name'];
    
    public static function boot()
    {
        parent::boot();
        Report::observe(ReportObserver::class);
    }
}
