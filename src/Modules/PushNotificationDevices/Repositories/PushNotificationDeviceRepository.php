<?php

namespace App\Modules\PushNotificationDevices\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\Modules\PushNotificationDevices\PushNotificationDevice;

class PushNotificationDeviceRepository extends BaseRepository
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
