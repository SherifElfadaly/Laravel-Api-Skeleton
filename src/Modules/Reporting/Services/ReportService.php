<?php

namespace App\Modules\Reporting\Services;

use App\Modules\Core\BaseClasses\BaseService;
use App\Modules\Reporting\Repositories\ReportRepository;
use App\Modules\Users\Services\UserService;

class ReportService extends BaseService
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Init new object.
     *
     * @param   ReportRepository $repo
     * @return  void
     */
    public function __construct(ReportRepository $repo, UserService $userService)
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
     * @param  boolean $skipPermission
     * @return object
     */
    public function getReport($reportName, $conditions = [], $perPage = 0, $skipPermission = false)
    {
        /**
         * Fetch the report from db.
         */
        $report = $this->repo->first(['report_name' => $reportName]);

        /**
         * Check report existance and permission.
         */
        if (! $report) {
            \Errors::notFound('report');
        } elseif (! $skipPermission && ! $this->userService->can($report->view_name, 'report')) {
            \Errors::noPermissions();
        }

        return $this->repo->renderReport($report, $conditions, $perPage);
    }
}
