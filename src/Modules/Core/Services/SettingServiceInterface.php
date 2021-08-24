<?php

namespace App\Modules\Core\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;

interface SettingServiceInterface extends BaseServiceInterface
{
    public function saveMany(array $data): void;
}
