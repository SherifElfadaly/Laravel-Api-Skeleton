<?php namespace App\Modules\V1\Notifications\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class NotificationRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Notifications\Notification';
	}

	/**
     * Set the notification notified to true.
     * 
     * @param  integer  $id
     * @return object
     */
    public function notified($id)
    {
        return $this->save(['id' => $id, 'notified' => 1]);
    }

    /**
     * Set the notification notified to all.
     * 
     * @return void
     */
    public function notifyAll()
    {
        $this->update(false, ['notified' => 1], 'notified');
    }
}
