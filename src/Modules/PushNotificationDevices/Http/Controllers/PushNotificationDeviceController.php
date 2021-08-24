<?php

namespace App\Modules\PushNotificationDevices\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\PushNotificationDevices\Http\Requests\RegisterDevice;
use App\Modules\PushNotificationDevices\Services\PushNotificationDeviceServiceInterface;

class PushNotificationDeviceController extends BaseApiController
{
    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest = 'App\Modules\Users\Http\PushNotificationDevices\StorePushNotificationDevice';

    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\PushNotificationDevices\Http\Resources\PushNotificationDevice';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['registerDevice'];

    /**
     * Init new object.
     *
     * @param   PushNotificationDeviceServiceInterface $service
     * @return  void
     */
    public function __construct(PushNotificationDeviceServiceInterface $service)
    {
        parent::__construct($service);
    }

    /**
     * Register the given device to the logged in user.
     *
     * @param RegisterDevice $request
     * @return \Illuminate\Http\Response
     */
    public function registerDevice(RegisterDevice $request)
    {
        return new $this->modelResource($this->service->registerDevice($request->all()));
    }
}
