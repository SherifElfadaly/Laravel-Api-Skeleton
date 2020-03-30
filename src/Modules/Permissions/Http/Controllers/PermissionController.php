<?php

namespace App\Modules\Permissions\Http\Controllers;

use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Permissions\Services\PermissionService;

class PermissionController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Permissions\Http\Resources\Permission';

    /**
     * Init new object.
     *
     * @param   PermissionService $service
     * @return  void
     */
    public function __construct(PermissionService $service)
    {
        parent::__construct($service);
    }
}
