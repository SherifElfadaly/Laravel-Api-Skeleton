<?php

namespace App\Modules\DummyModule\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\DummyModule\Services\DummyService;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\DummyModule\Http\Requests\InsertDummy;
use App\Modules\DummyModule\Http\Requests\UpdateDummy;

class DummyController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\DummyModule\Http\Resources\DummyModel';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = [];

    /**
     * List of all route actions that the base api controller
     * will skip login check for them.
     * @var array
     */
    protected $skipLoginCheck = [];

    /**
     * Init new object.
     *
     * @param   DummyService $service
     * @return  void
     */
    public function __construct(DummyService $service)
    {
        parent::__construct($service);
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertDummy $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertDummy $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateDummy $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDummy $request)
    {
        return new $this->modelResource($this->service->save($request->all()));
    }
}
