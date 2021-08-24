<?php

namespace App\Modules\Notifications\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NotificationServiceInterface extends BaseServiceInterface
{
    /**
     * Retrieve all notifications of the logged in user.
     *
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function my(int $perPage): LengthAwarePaginator;


    /**
     * Retrieve unread notifications of the logged in user.
     *
     * @param  int $perPage
     * @return LengthAwarePaginator
     */
    public function unread(int $perPage): LengthAwarePaginator;


    /**
     * Mark the notification as read.
     *
     * @param  int  $id
     * @return bool
     */
    public function markAsRead(int $id): bool;

    /**
     * Mark all notifications as read.
     *
     * @return bool
     */
    public function markAllAsRead(): bool;

    /**
     * Notify th given user with the given notification.
     *
     * @param  mixed    $users
     * @param  string   $notification
     * @param  Variadic $notificationData
     * @return void
     */
    public function notify(mixed $users, string $notification, ...$notificationData): bool;
}
