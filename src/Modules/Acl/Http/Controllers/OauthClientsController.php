<?php

namespace App\Modules\Acl\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseApiController;
use \App\Modules\Acl\Repositories\OauthClientRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class OauthClientsController extends BaseApiController
{
    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules = [
        'name'     => 'required|max:255',
        'redirect' => 'required|url',
        'user_id'  => 'required|exists:users,id',
        'revoked'  => 'boolean'
    ];

    /**
     * Init new object.
     *
     * @param   OauthClientRepository $repo
     * @param   CoreConfig            $config
     * @return  void
     */
    public function __construct(OauthClientRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Acl\Http\Resources\OauthClient');
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
