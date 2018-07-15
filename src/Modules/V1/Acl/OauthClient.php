<?php

namespace App\Modules\V1\Acl;

use Laravel\Passport\Client;

class OauthClient extends Client
{
    protected $dates    = ['created_at', 'updated_at'];
    protected $fillable = ['name', 'redirect', 'user_id', 'personal_access_client', 'password_client', 'revoked'];
    public $searchable  = ['name'];
    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->tz(\Session::get('time-zone'))->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->tz(\Session::get('time-zone'))->toDateTimeString();
    }
    
    public static function boot()
    {
        parent::boot();
        parent::observe(\App::make('App\Modules\V1\Acl\ModelObservers\OauthClientObserver'));
    }
}
