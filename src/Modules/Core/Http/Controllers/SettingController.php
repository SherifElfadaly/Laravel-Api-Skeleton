<?php

namespace App\Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Core\Repositories\SettingRepository;
use App\Modules\Core\Http\Resources\General as GeneralResource;
use App\Modules\Core\Http\Requests\UpdateSetting;

class SettingController extends BaseApiController
{
    /**
     * Init new object.
     *
     * @param   SettingRepository $repo
     * @return  void
     */
    public function __construct(SettingRepository $repo)
    {
        parent::__construct($repo, 'App\Modules\Core\Http\Resources\Setting');
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateSetting $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSetting $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Save list of settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveMany(Request $request)
    {
        return new GeneralResource($this->repo->saveMany($request->all()));
    }
}
