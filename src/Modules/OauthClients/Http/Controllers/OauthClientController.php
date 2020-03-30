<?php

namespace App\Modules\OauthClients\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\OauthClients\Services\OauthClientService;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\OauthClients\Http\Requests\InsertOauthClient;
use App\Modules\OauthClients\Http\Requests\UpdateOauthClient;

class OauthClientController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\OauthClients\Http\Resources\OauthClient';

    /**
     * Init new object.
     *
     * @param   OauthClientService $service
     * @return  void
     */
    public function __construct(OauthClientService $service)
    {
        parent::__construct($service);
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertOauthClient $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertOauthClient $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateOauthClient $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOauthClient $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Revoke the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function revoke($clientId)
    {
        return new GeneralResource($this->service->revoke($clientId));
    }

    /**
     * Un revoke the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function unRevoke($clientId)
    {
        return new GeneralResource($this->service->unRevoke($clientId));
    }
}
