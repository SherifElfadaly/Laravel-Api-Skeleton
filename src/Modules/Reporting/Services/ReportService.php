<?php

namespace App\Modules\Reporting\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Core\Facades\Errors;
use App\Modules\Reporting\Repositories\ReportRepositoryInterface;
use App\Modules\Users\Services\UserServiceInterface;

class ReportService extends BaseService implements ReportServiceInterface
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * Init new object.
     *
     * @param   ReportRepositoryInterface $repo
     * @param   UserServiceInterface $userService
     * @return  void
     */
    public function __construct(ReportRepositoryInterface $repo, UserServiceInterface $userService)
    {
        $this->userService = $userService;
        parent::__construct($repo);
    }

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
    public function getReport(string $reportName, array $conditions = [], int $perPage = 0, bool $skipPermission = false): mixed
    {
        /**
         * Fetch the report from db.
         */
        $report = $this->repo->first(['report_name' => $reportName]);

        /**
         * Check report existance and permission.
         */
        if (! $report) {
            Errors::notFound('report');
        } elseif (! $skipPermission && ! $this->userService->can($report->view_name, 'report')) {
            Errors::noPermissions();
        }

        return $this->repo->renderReport($report, $conditions, $perPage);
    }
}
