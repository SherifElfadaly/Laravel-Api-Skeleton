<?php

namespace App\Modules\DummyModule\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\DummyModule\Repositories\DummyRepository;

class DummyService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   DummyRepository $repo
     * @return  void
     */
    public function __construct(DummyRepository $repo)
    {
        parent::__construct($repo);
    }
}
