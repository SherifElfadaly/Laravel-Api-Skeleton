<?php

namespace App\Modules\Core\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Core\Repositories\SettingRepository;

class SettingService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   SettingRepository $repo
     * @return  void
     */
    public function __construct(SettingRepository $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Save list of settings.
     *
     * @param  array   $data
     * @return void
     */
    public function saveMany(array $data)
    {
        \DB::transaction(function () use ($data) {
            foreach ($data as $value) {
                $this->repo->save($value);
            }
        });
    }
}
