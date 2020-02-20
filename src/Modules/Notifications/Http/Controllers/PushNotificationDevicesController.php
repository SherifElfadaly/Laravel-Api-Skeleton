<?php

namespace App\Modules\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;
use \App\Modules\Notifications\Repositories\PushNotificationDeviceRepository;
use App\Modules\Core\Utl\CoreConfig;

class PushNotificationDevicesController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['registerDevice'];

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules = [
    'device_token' => 'required|string|max:255',
    'user_id'      => 'required|exists:users,id'
    ];

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
     * Register the given device to the logged in user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerDevice(Request $request)
    {
        $this->validate($request, [
            'device_token' => 'required|string|max:255'
            ]);

        return new $this->modelResource($this->repo->registerDevice($request->all()));
    }
}
