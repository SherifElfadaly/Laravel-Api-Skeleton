<?php

namespace App\Modules\PushNotificationDevices\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\PushNotificationDevices\Services\PushNotificationDeviceService;
use App\Modules\PushNotificationDevices\Http\Requests\RegisterDevice;
use App\Modules\PushNotificationDevices\Http\Requests\InsertPushNotificationDevice;
use App\Modules\PushNotificationDevices\Http\Requests\UpdatePushNotificationDevice;

class PushNotificationDeviceController extends BaseApiController
{
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
     * @param   PushNotificationDeviceService $service
     * @return  void
     */
    public function __construct(PushNotificationDeviceService $service)
    {
        parent::__construct($service);
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertPushNotificationDevice $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertPushNotificationDevice $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdatePushNotificationDevice $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePushNotificationDevice $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
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
