<?php

namespace App\Modules\DummyModule\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\DummyModule\Repositories\DummyRepositoryInterface;

class DummyService extends BaseService implements DummyServiceInterface
{
    /**
     * Init new object.
     *
     * @param   DummyRepositoryInterface $repo
     * @return  void
     */
    public function __construct(DummyRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }
}
