<?php

namespace App\Modules\Notifications\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Notifications\Notification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
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
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function my(int $perPage): LengthAwarePaginator
    {
        return Auth::user()->notifications()->paginate($perPage);
    }

    /**
     * Retrieve unread notifications of the logged in user.
     *
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function unread(int $perPage): LengthAwarePaginator
    {
        return Auth::user()->unreadNotifications()->paginate($perPage);
    }

    /**
     * Mark the notification as read.
     *
     * @param  int  $id
     * @return bool
     */
    public function markAsRead(int $id): bool
    {
        if ($notification = Auth::user()->unreadNotifications()->where('id', $id)->first()) {
            $notification->markAsRead();
        }

        return true;
    }

    /**
     * Mark all notifications as read.
     *
     * @return bool
     */
    public function markAllAsRead(): bool
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return true;
    }
}
