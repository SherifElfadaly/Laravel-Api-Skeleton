<?php

namespace App\Modules\PushNotificationDevices\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\PushNotificationDevices\Repositories\PushNotificationDeviceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PushNotificationDeviceService extends BaseService implements PushNotificationDeviceServiceInterface
{
    /**
     * Init new object.
     *
     * @param   PushNotificationDeviceRepositoryInterface $repo
     * @return  void
     */
    public function __construct(PushNotificationDeviceRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Register the given device to the logged in user.
     *
     * @param  array $data
     * @return Model
     */
    public function registerDevice(array $data): Model
    {
        $data['access_token'] = Auth::user()->token();
        $data['user_id']      = Auth::id();
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
