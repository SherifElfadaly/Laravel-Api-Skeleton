<?php

namespace App\Modules\Reporting\Repositories;

use App\Modules\Core\BaseClasses\Contracts\BaseRepositoryInterface;

interface ReportRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Render the given report db view based on the given
     * condition.
     *
     * @param  mixed $report
     * @param  array $conditions
     * @param  int   $perPage
     * @return mixed
     */
    public function renderReport(mixed $report, array $conditions = [], int $perPage = 0): mixed;
}
