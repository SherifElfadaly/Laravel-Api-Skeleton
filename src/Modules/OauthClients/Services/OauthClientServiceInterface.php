<?php

namespace App\Modules\OauthClients\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface OauthClientServiceInterface extends BaseServiceInterface
{
    /**
     * Revoke the given client.
     *
     * @param  int  $clientId
     * @return Model
     */
    public function revoke(int $clientId): Model;

    /**
     * UnRevoke the given client.
     *
     * @param  int  $clientId
     * @return Model
     */
    public function unRevoke(int $clientId): Model;

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return bool
     */
    public function accessTokenExpiredOrRevoked(string $accessToken): bool;


    /**
     * Revoke the given access token and all
     * associated refresh tokens.
     *
     * @param  oject $accessToken
     * @return bool
     */
    public function revokeAccessToken(object $accessToken): bool;
}
