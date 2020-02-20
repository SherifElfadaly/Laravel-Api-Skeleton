<?php

namespace App\Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;
use App\Modules\Core\Repositories\SettingRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class SettingsController extends BaseApiController
{
    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules = [
        'id'    => 'required|exists:settings,id',
        'value' => 'required|string'
    ];

    /**
     * Init new object.
     *
     * @param   SettingRepository $repo
     * @param   CoreConfig        $config
     * @return  void
     */
    public function __construct(SettingRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Core\Http\Resources\Setting');
    }

    /**
     * Save list of settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveMany(Request $request)
    {
        return new GeneralResource($this->repo->saveMany($request->all()));
    }
}
