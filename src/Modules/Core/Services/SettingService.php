<?php

namespace App\Modules\Core\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Core\Repositories\SettingRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SettingService extends BaseService implements SettingServiceInterface
{
    /**
     * Init new object.
     *
     * @param   SettingRepositoryInterface $repo
     * @return  void
     */
    public function __construct(SettingRepositoryInterface $repo)
    {
        parent::__construct($repo);
    }

    /**
     * Save list of settings.
     *
     * @param  array   $data
     * @return void
     */
    public function saveMany(array $data): void
    {
        DB::transaction(function () use ($data) {
            foreach ($data as $value) {
                $this->repo->save($value);
            }
        });
    }
}
