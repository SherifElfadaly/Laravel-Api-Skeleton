<?php

namespace App\Modules\Reporting\Services;

use App\Modules\Core\BaseClasses\Contracts\BaseServiceInterface;

interface ReportServiceInterface extends BaseServiceInterface
{
    /**
     * Render the given report db view based on the given
     * condition.
     *
     * @param  string  $reportName
     * @param  array   $conditions
     * @param  integer $perPage
     * @param  bool    $skipPermission
     * @return mixed
     */
    public function getReport(string $reportName, array $conditions = [], int $perPage = 0, bool $skipPermission = false): mixed;
}
