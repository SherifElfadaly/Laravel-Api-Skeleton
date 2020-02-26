<?php

namespace App\Modules\Notifications\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Notifications\Repositories\PushNotificationDeviceRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Notifications\Http\Requests\RegisterDevice;
use App\Modules\Notifications\Http\Requests\InsertPushNotificationDevice;
use App\Modules\Notifications\Http\Requests\UpdatePushNotificationDevice;

class PushNotificationDeviceController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['registerDevice'];

    /**
     * Init new object.
     *
     * @param   PushNotificationDeviceRepository $repo
     * @param   CoreConfig                       $config
     * @return  void
     */
    public function __construct(PushNotificationDeviceRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Notifications\Http\Resources\PushNotificationDevice');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertPushNotificationDevice $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertPushNotificationDevice $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdatePushNotificationDevice $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePushNotificationDevice $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Register the given device to the logged in user.
     *
     * @param RegisterDevice $request
     * @return \Illuminate\Http\Response
     */
    public function registerDevice(RegisterDevice $request)
    {
        return new $this->modelResource($this->repo->registerDevice($request->all()));
    }
}
