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
     * Retrieve all notifications of the logged in user.
     * 
     * @param  integer $perPage
     * @return Collection
     */
    public function all($perPage)
    {
        return \JWTAuth::parseToken()->authenticate()->notifications()->paginate($perPage);
    }

    /**
     * Retrieve unread notifications of the logged in user.
     * 
     * @param  integer $perPage
     * @return Collection
     */
    public function unread($perPage)
    {
        return \JWTAuth::parseToken()->authenticate()->unreadNotifications()->paginate($perPage);
    }

	/**
     * Mark the notification as read.
     * 
     * @param  integer  $id
     * @return object
     */
    public function markAsRead($id)
    {
        \JWTAuth::parseToken()->authenticate()->unreadNotifications()->where('id', $id)->first()->markAsRead();
    }

    /**
     * Mark all notifications as read.
     * 
     * @return void
     */
    public function markAllAsRead()
    {
        \JWTAuth::parseToken()->authenticate()->unreadNotifications()->update(['read_at' => now()]);
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
        \Notification::send($users, new App\Modules\V1\Notifications\Notifications\$notification($notificationData));
    }
}
