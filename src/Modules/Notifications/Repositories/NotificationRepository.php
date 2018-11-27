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
	 * Retrieve all notifications of the logged in user.
	 * 
	 * @param  integer $perPage
	 * @return Collection
	 */
	public function list($perPage)
	{
		return \Auth::user()->notifications()->paginate($perPage);
	}

	/**
	 * Retrieve unread notifications of the logged in user.
	 * 
	 * @param  integer $perPage
	 * @return Collection
	 */
	public function unread($perPage)
	{
		return \Auth::user()->unreadNotifications()->paginate($perPage);
	}

	/**
	 * Mark the notification as read.
	 * 
	 * @param  integer  $id
	 * @return object
	 */
	public function markAsRead($id)
	{
		if ($notification = \Auth::user()->unreadNotifications()->where('id', $id)) 
		{
			$notification->first()->markAsRead();
		}
	}

	/**
	 * Mark all notifications as read.
	 * 
	 * @return void
	 */
	public function markAllAsRead()
	{
		\Auth::user()->unreadNotifications()->update(['read_at' => now()]);
	}

	/**
	 * Notify th given user with the given notification.
	 * 
	 * @param  collection $users
	 * @param  string     $notification
	 * @param  object     $notificationData
	 * @return void
	 */
	public function notify($users, $notification, $notificationData = false)
	{
		$notification = 'App\Modules\Notifications\Notifications\\' . $notification;
		\Notification::send($users, new $notification($notificationData));
	}
}
