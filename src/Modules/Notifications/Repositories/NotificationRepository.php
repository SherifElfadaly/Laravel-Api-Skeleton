<?php

namespace App\Modules\Notifications\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Notifications\Notification;

class NotificationRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Notification $model
     * @return  void
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    /**
     * Retrieve all notifications of the logged in user.
     *
     * @param  integer $perPage
     * @return Collection
     */
    public function my($perPage)
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
        if ($notification = \Auth::user()->unreadNotifications()->where('id', $id)->first()) {
            $notification->markAsRead();
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
}
