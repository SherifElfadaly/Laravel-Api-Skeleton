<?php

namespace App\Modules\Core\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Core\Setting;

class SettingRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Setting $model
     * @return  void
     */
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }
}
