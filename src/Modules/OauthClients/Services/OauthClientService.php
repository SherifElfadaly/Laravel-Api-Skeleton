<?php

namespace App\Modules\OauthClients\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\OauthClients\Repositories\OauthClientRepository;

class OauthClientService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   OauthClientRepository $repo
     * @return  void
     */
    public function __construct(OauthClientRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Revoke the given client.
     *
     * @param  integer  $clientId
     * @return void
     */
    public function revoke($clientId)
    {
        \DB::transaction(function () use ($data) {
            $client = $this->repo->find($clientId);
            $this->repo->revokeClientTokens($client);
            $this->repo->save(['id'=> $clientId, 'revoked' => true]);
        });
    }

    /**
     * UnRevoke the given client.
     *
     * @param  integer  $clientId
     * @return void
     */
    public function unRevoke($clientId)
    {
        $this->repo->save(['id'=> $clientId, 'revoked' => false]);
    }

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return boolean
     */
    public function accessTokenExpiredOrRevoked($accessToken)
    {
        return $this->oauthClientRepository->accessTokenExpiredOrRevoked($accessToken);
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
        return $this->oauthClientRepository->revokeAccessToken($accessToken);
    }
}
