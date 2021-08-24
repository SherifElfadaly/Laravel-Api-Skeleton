<?php

namespace App\Modules\OauthClients\Repositories;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;

interface OauthClientRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Revoke the given client tokens.
     *
     * @param  mixed  $client
     * @return bool
     */
    public function revokeClientTokens($client): bool;


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
