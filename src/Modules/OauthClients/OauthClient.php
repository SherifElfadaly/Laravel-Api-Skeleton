<?php

namespace App\Modules\OauthClients;

use Laravel\Passport\Client;
use App\Modules\Users\AclUser;
use App\Modules\OauthClients\ModelObservers\OauthClientObserver;

class OauthClient extends Client
{
    protected $dates = ['created_at', 'updated_at'];
    public $fillable = ['name', 'redirect', 'user_id', 'personal_access_client', 'password_client', 'revoked'];
    
    public function user()
    {
        return $this->belongsTo(AclUser::class);
    }
    
    public static function boot()
    {
        parent::boot();
        OauthClient::observe(OauthClientObserver::class);
    }
}
