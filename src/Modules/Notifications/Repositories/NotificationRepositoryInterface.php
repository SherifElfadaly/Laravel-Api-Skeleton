<?php

namespace App\Modules\Notifications\Repositories;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NotificationRepositoryInterface extends BaseRepositoryInterface
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
}
