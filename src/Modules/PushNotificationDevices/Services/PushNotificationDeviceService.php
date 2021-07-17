<?php

namespace App\Modules\PushNotificationDevices\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\PushNotificationDevices\Repositories\PushNotificationDeviceRepository;
use Illuminate\Contracts\Session\Session;

class PushNotificationDeviceService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   PushNotificationDeviceRepository $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(PushNotificationDeviceRepository $repo, Session $session)
    {
        parent::__construct($repo, $session);
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
