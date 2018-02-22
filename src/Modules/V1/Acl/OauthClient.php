<?php

namespace App\Modules\V1\Acl\Http\Controllers;

use Laravel\Passport\Client;

class OauthClient extends Client
{
    protected $dates    = ['created_at', 'updated_at'];
    protected $fillable = ['name', 'redirect', 'user_id', 'personal_access_client', 'password_client', 'revoked'];
    public $searchable  = ['name'];
    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->addHours(\Session::get('timeZoneDiff'))->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->addHours(\Session::get('timeZoneDiff'))->toDateTimeString();
    }
    
    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\OauthClientObserver'));
    }
}
