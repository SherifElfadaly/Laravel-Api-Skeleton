<?php

namespace App\Modules\OauthClients\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\OauthClients\Services\OauthClientServiceInterface;

class OauthClientController extends BaseApiController
{
    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest = 'App\Modules\OauthClients\Http\Requests\StoreOauthClient';
    
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\OauthClients\Http\Resources\OauthClient';

    /**
     * Init new object.
     *
     * @param   OauthClientServiceInterface $service
     * @return  void
     */
    public function __construct(OauthClientServiceInterface $service)
    {
        parent::__construct($service);
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
