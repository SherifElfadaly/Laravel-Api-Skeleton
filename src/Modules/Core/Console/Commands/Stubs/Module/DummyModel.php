<?php

namespace App\Modules\DummyModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\DummyModule\ModelObservers\DummyObserver;

class DummyModel extends Model
{
    use SoftDeletes;
    protected $table    = 'DummyTableName';
    protected $dates    = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden   = ['deleted_at'];
    protected $guarded  = ['id'];
    protected $fillable = []; // Add attributes here
    
    public static function boot()
    {
        parent::boot();
        DummyModel::observe(DummyObserver::class);
    }
}
