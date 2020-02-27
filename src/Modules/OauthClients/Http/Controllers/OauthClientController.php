<?php

namespace App\Modules\OauthClients\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\OauthClients\Repositories\OauthClientRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\OauthClients\Http\Requests\InsertOauthClient;
use App\Modules\OauthClients\Http\Requests\UpdateOauthClient;

class OauthClientController extends BaseApiController
{
    /**
     * Init new object.
     *
     * @param   OauthClientRepository $repo
     * @param   CoreConfig            $config
     * @return  void
     */
    public function __construct(OauthClientRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\OauthClients\Http\Resources\OauthClient');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertOauthClient $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertOauthClient $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateOauthClient $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOauthClient $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Revoke the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function revoke($clientId)
    {
        return new GeneralResource($this->repo->revoke($clientId));
    }

    /**
     * Un revoke the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function unRevoke($clientId)
    {
        return new GeneralResource($this->repo->unRevoke($clientId));
    }
}
