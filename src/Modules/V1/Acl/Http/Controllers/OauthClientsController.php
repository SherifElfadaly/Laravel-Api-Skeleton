<?php
namespace App\Modules\V1\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;


class OauthClientsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model               = 'oauthClients';

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules  = [
        'name'                   => 'required|max:255',
        'redirect'               => 'required|url',
        'user_id'                => 'required|array|exists:users,id',
        'personal_access_client' => 'boolean',
        'password_client'        => 'boolean',
        'revoked'                => 'boolean'
    ];

    /**
     * Revoke the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function revoke($clientId)
    {
        return \Response::json($this->repo->revoke($clientId), 200);
    }

    /**
     * Regenerate seceret for the given client.
     *
     * @param  integer  $clientId Id of the client
     * @return \Illuminate\Http\Response
     */
    public function regenerateSecret($clientId)
    {
        return \Response::json($this->repo->regenerateSecret($clientId), 200);
    }
}
