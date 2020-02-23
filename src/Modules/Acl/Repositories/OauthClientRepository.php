<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Acl\OauthClient;

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
     * Revoke the given client.
     *
     * @param  integer  $clientId
     * @return void
     */
    public function revoke($clientId)
    {
        $client = $this->find($clientId);
        $client->tokens()->update(['revoked' => true]);
        $this->save(['id'=> $clientId, 'revoked' => true]);
    }

    /**
     * Un revoke the given client.
     *
     * @param  integer  $clientId
     * @return void
     */
    public function unRevoke($clientId)
    {
        $this->save(['id'=> $clientId, 'revoked' => false]);
    }
}
