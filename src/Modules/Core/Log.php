<?php namespace App\Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model{

    use SoftDeletes;
    protected $table    = 'logs';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at', 'item_type'];
    protected $guarded  = ['id'];
    protected $fillable = ['action', 'item_name', 'item_type', 'item_id', 'user_id'];

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
        return $this->belongsTo('App\Modules\Acl\AclUser');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();
    }
}
