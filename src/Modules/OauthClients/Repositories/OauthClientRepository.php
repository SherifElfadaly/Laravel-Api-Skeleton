<?php

namespace App\Modules\OauthClients\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\OauthClients\OauthClient;
use Illuminate\Support\Facades\DB;

class OauthClientRepository extends BaseRepository implements OauthClientRepositoryInterface
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
     * @return bool
     */
    public function revokeClientTokens($client): bool
    {
        $client = ! filter_var($client, FILTER_VALIDATE_INT) ? $client : $this->find($client);
        $client->tokens()->update(['revoked' => true]);

        return true;
    }

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return bool
     */
    public function accessTokenExpiredOrRevoked(string $accessToken): bool
    {
        $accessTokenId = json_decode($accessToken, true)['id'];
        $accessToken   = DB::table('oauth_access_tokens')
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
     * @return bool
     */
    public function revokeAccessToken(object $accessToken): bool
    {
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        return true;
    }
}
