<?php

namespace App\Modules\Core\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Core\Repositories\SettingRepository;
use Illuminate\Contracts\Session\Session;

class SettingService extends BaseService
{
    /**
     * Init new object.
     *
     * @param   SettingRepository $repo
     * @param   Session $session
     * @return  void
     */
    public function __construct(SettingRepository $repo, Session $session)
    {
        parent::__construct($repo, $session);
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
