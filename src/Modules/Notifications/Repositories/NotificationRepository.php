<?php namespace App\Modules\Notifications\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class NotificationRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Notifications\Notification';
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
        \Core::notifications()->update(false, ['notified' => 1], 'notified');
    }
}
