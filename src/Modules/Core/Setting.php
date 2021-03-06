<?php

namespace App\Modules\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Core\ModelObservers\SettingsObserver;
use App\Modules\Core\Traits\Translatable;

class Setting extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'settings';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['deleted_at'];
    protected $guarded = ['id', 'key'];
    public $fillable = ['name', 'value'];
    public $translatable = ['value'];
    public $casts = ['value' => 'json'];
    
    public function newCollection(array $models = [])
    {
        return parent::newCollection($models)->keyBy('key');
    }

    public static function boot()
    {
        parent::boot();
        Setting::observe(SettingsObserver::class);
    }
}
