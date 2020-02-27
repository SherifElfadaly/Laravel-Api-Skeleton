<?php

namespace App\Modules\OauthClients;

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
    
    public function user()
    {
        return $this->belongsTo('App\Modules\Users\AclUser');
    }
    
    public static function boot()
    {
        parent::boot();
        OauthClient::observe(\App::make('App\Modules\OauthClients\ModelObservers\OauthClientObserver'));
    }
}
