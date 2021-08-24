<?php

namespace App\Modules\PushNotificationDevices\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;
use Illuminate\Database\Eloquent\Model;

interface PushNotificationDeviceServiceInterface extends BaseServiceInterface
{
    /**
     * Register the given device to the logged in user.
     *
     * @param  array $data
     * @return Model
     */
    public function registerDevice(array $data): Model;
}
