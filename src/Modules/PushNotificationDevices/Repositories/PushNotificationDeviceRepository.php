<?php

namespace App\Modules\PushNotificationDevices\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\PushNotificationDevices\PushNotificationDevice;

class PushNotificationDeviceRepository extends BaseRepository implements PushNotificationDeviceRepositoryInterface
{
    /**
     * Init new object.
     *
     * @param   PushNotificationDevice $model
     * @return  void
     */
    public function __construct(PushNotificationDevice $model)
    {
        parent::__construct($model);
    }
}
