<?php

namespace App\Modules\DummyModule\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\DummyModule\DummyModel;

class DummyRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   DummyModel $model
     * @return  void
     */
    public function __construct(DummyModel $model)
    {
        parent::__construct($model);
    }
}
