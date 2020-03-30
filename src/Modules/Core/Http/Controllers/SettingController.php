<?php

namespace App\Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Core\Services\SettingService;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\Core\Http\Requests\UpdateSetting;

class SettingController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Core\Http\Resources\Setting';

    /**
     * Init new object.
     *
     * @param   SettingService $service
     * @return  void
     */
    public function __construct(SettingService $service)
    {
        parent::__construct($service);
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateSetting $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetting $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Save list of settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveMany(Request $request)
    {
        return new GeneralResource($this->service->saveMany($request->all()));
    }
}
