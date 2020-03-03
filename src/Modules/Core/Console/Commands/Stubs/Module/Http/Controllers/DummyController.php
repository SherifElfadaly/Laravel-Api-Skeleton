<?php

namespace App\Modules\DummyModule\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\DummyModule\Repositories\DummyRepository;
use App\Modules\Core\Utl\CoreConfig;
use App\Modules\DummyModule\Http\Requests\InsertDummy;
use App\Modules\DummyModule\Http\Requests\UpdateDummy;

class DummyController extends BaseApiController
{
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
     * @param   DummyRepository $repo
     * @param   CoreConfig      $config
     * @return  void
     */
    public function __construct(DummyRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\DummyModule\Http\Resources\DummyModel');
    }

    /**
     * Insert the given model to storage.
     *
     * @param InsertDummy $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InsertDummy $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }

    /**
     * Update the given model to storage.
     *
     * @param UpdateDummy $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDummy $request)
    {
        return new $this->modelResource($this->repo->save($request->all()));
    }
}
