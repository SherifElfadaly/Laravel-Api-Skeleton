<?php

namespace App\Modules\DummyModule\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\DummyModule\Services\DummyService;
use App\Modules\DummyModule\Http\Requests\StoreDummy;

class DummyController extends BaseApiController
{
    /**
     * Path of the sotre form request.
     *
     * @var string
     */
    protected $storeFormRequest = 'App\Modules\DummyModule\Http\Requests\StoreDummy';
    
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
}
