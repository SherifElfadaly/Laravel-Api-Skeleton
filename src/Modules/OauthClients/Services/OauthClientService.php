<?php

namespace App\Modules\OauthClients\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\OauthClients\Repositories\OauthClientRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OauthClientService extends BaseService implements OauthClientServiceInterface
{
    /**
     * Init new object.
     *
     * @param   OauthClientRepositoryInterface $repo
     * @return  void
     */
    public function __construct(OauthClientRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Revoke the given client.
     *
     * @param  int  $clientId
     * @return Model
     */
    public function revoke(int $clientId): Model
    {
        return DB::transaction(function () use ($clientId) {
            $client = $this->repo->find($clientId);
            $this->repo->revokeClientTokens($client);
            return $this->repo->save(['id'=> $clientId, 'revoked' => true]);
        });
    }

    /**
     * UnRevoke the given client.
     *
     * @param  int  $clientId
     * @return Model
     */
    public function unRevoke(int $clientId): Model
    {
        return $this->repo->save(['id'=> $clientId, 'revoked' => false]);
    }

    /**
     * Ensure access token hasn't expired or revoked.
     *
     * @param  string $accessToken
     * @return bool
     */
    public function accessTokenExpiredOrRevoked(string $accessToken): bool
    {
        return $this->repo->accessTokenExpiredOrRevoked($accessToken);
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
        return $this->repo->revokeAccessToken($accessToken);
    }
}
