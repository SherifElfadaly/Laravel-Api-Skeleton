<?php

namespace App\Modules\OauthClients\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\OauthClients\OauthClient;

class OauthClientRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   OauthClient $model
     * @return  void
     */
    public function __construct(OauthClient $model)
    {
        parent::__construct($model);
    }

    /**
     * Revoke the given client tokens.
     *
     * @param  mixed  $client
     * @return void
     */
    public function revokeClientTokens($client)
    {
        $client = is_int($client) ? $client : $this->find($client);
        $client->tokens()->update(['revoked' => true]);
    }

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return boolean
     */
    public function accessTokenExpiredOrRevoked($accessToken)
    {
        $accessTokenId = json_decode($accessToken, true)['id'];
        $accessToken   = \DB::table('oauth_access_tokens')
                ->where('id', $accessTokenId)
                ->first();
        
        if (\Carbon\Carbon::parse($accessToken->expires_at)->isPast() || $accessToken->revoked) {
            return true;
        }

        return false;
    }

    /**
     * Revoke the given access token and all
     * associated refresh tokens.
     *
     * @param  oject $accessToken
     * @return void
     */
    public function revokeAccessToken($accessToken)
    {
        \DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
    }
}
