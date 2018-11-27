<?php
namespace App\Modules\Acl\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Core\Http\Controllers\BaseApiController;
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
		'name'     => 'required|max:255',
		'redirect' => 'required|url',
		'user_id'  => 'required|exists:users,id',
		'revoked'  => 'boolean'
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
	 * Un revoke the given client.
	 *
	 * @param  integer  $clientId Id of the client
	 * @return \Illuminate\Http\Response
	 */
	public function unRevoke($clientId)
	{
		return \Response::json($this->repo->unRevoke($clientId), 200);
	}
}
