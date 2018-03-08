<?php namespace App\Modules\V1\Acl\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class OauthClientRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Acl\OauthClient';
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
        $client->forceFill(['revoked' => true])->save();
    }

    /**
     * Regenerate seceret for the given client.
     *
     * @param  integer  $clientId
     * @return void
     */
    public function regenerateSecret($clientId)
    {
		$this->update($clientId, ['secret' => str_random(40)]);
    }
}
