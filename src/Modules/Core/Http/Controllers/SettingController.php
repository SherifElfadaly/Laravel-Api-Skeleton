<?php

namespace App\Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Core\Services\SettingService;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class SettingController extends BaseApiController
{
    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest = 'App\Modules\Core\Http\Requests\StoreSetting';

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
