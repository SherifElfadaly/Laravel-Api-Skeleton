<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Notifications\Repositories\NotificationRepository;
use App\Modules\Users\Repositories\UserRepository;
use Illuminate\Contracts\Session\Session;

class NotificationService extends BaseService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Init new object.
     *
     * @param   NotificationRepository $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(NotificationRepository $repo, UserRepository $userRepository, Session $session)
    {
        $this->userRepository = $userRepository;
        parent::__construct($repo, $session);
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
     * @param  Variadic   $notificationData
     * @return void
     */
    public function notify($users, $notification, ...$notificationData)
    {
        $users = is_array($users) ? $this->userRepository->findBy(['id' => ['op' => 'in', 'val' => $users]]) : $users;
        $notification = 'App\Modules\Notifications\Notifications\\'.$notification;
        \Notification::send($users, new $notification(...$notificationData));
    }
}
