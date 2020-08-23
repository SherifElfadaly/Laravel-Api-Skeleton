<?php

namespace App\Modules\PushNotificationDevices\Services;

use App\Modules\Core\BaseClasses\BaseService;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\Modules\PushNotificationDevices\Repositories\PushNotificationDeviceRepository;

class PushNotificationDeviceService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   PushNotificationDeviceRepository $repo
     * @return  void
     */
    public function __construct(PushNotificationDeviceRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Register the given device to the logged in user.
     *
     * @param  array $data
     * @return void
     */
    public function registerDevice($data)
    {
        $data['access_token'] = \Auth::user()->token();
        $data['user_id']      = \Auth::id();
        $device               = $this->repo->first([
            'and' => [
                'device_token' => $data['device_token'],
                'user_id' => $data['user_id']
                ]
            ]);

        if ($device) {
            $data['id'] = $device->id;
        }

        return $this->repo->save($data);
    }
}
