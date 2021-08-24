<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Notifications\Repositories\NotificationRepositoryInterface;
use App\Modules\Users\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;

class NotificationService extends BaseService implements NotificationServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * Init new object.
     *
     * @param   NotificationServiceInterface $repo
     * @return  void
     */
    public function __construct(NotificationRepositoryInterface $repo, UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($repo);
    }

    /**
     * Retrieve all notifications of the logged in user.
     *
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function my(int $perPage): LengthAwarePaginator
    {
        return $this->repo->my($perPage);
    }

    /**
     * Retrieve unread notifications of the logged in user.
     *
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function unread(int $perPage): LengthAwarePaginator
    {
        return $this->repo->unread($perPage);
    }

    /**
     * Mark the notification as read.
     *
     * @param  int  $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        return $this->repo->markAsRead($id);
    }

    /**
     * Mark all notifications as read.
     *
     * @return bool
     */
    public function markAllAsRead(): bool
    {
        return $this->repo->markAllAsRead();
    }

    /**
     * Notify th given user with the given notification.
     *
     * @param  mixed    $users
     * @param  string   $notification
     * @param  Variadic $notificationData
     * @return void
     */
    public function notify(mixed $users, string $notification, ...$notificationData): bool
    {
        $users = is_array($users) ? $this->userRepository->findBy(['id' => ['op' => 'in', 'val' => $users]]) : $users;
        $notification = 'App\Modules\Notifications\Notifications\\'.$notification;
        Notification::send($users, new $notification(...$notificationData));

        return true;
    }
}
