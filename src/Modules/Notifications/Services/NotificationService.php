<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Notifications\Repositories\NotificationRepository;

class NotificationService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   NotificationRepository $repo
     * @return  void
     */
    public function __construct(NotificationRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Retrieve all notifications of the logged in user.
     *
     * @param  integer $perPage
     * @return Collection
     */
    public function my($perPage)
    {
        return $this->repo->my($perPage);
    }

    /**
     * Retrieve unread notifications of the logged in user.
     *
     * @param  integer $perPage
     * @return Collection
     */
    public function unread($perPage)
    {
        return $this->repo->unread($perPage);
    }

    /**
     * Mark the notification as read.
     *
     * @param  integer  $id
     * @return object
     */
    public function markAsRead($id)
    {
        return $this->repo->markAsRead($id);
    }

    /**
     * Mark all notifications as read.
     *
     * @return void
     */
    public function markAllAsRead()
    {
        return $this->repo->markAllAsRead();
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
        $notification = 'App\Modules\Notifications\Notifications\\'.$notification;
        \Notification::send($users, new $notification($notificationData));
    }
}
