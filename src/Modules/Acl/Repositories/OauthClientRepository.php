<?php namespace App\Modules\Acl\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class OauthClientRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Acl\OauthClient';
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
