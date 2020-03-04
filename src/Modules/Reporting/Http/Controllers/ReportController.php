<?php

namespace App\Modules\Reporting\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Reporting\Repositories\ReportRepository;
use App\Modules\Core\Utl\CoreConfig;

class ReportController extends BaseApiController
{
    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['getReport'];

    /**
     * Init new object.
     *
     * @param   ReportRepository $repo
     * @param   CoreConfig       $config
     * @return  void
     */
    public function __construct(ReportRepository $repo, CoreConfig $config)
    {
        parent::__construct($repo, $config, 'App\Modules\Reporting\Http\Resources\Report');
    }

    /**
     * Render the given report name with the given conditions.
     *
     * @param Request $request
     * @param  string $reportName Name of the requested report
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request, $reportName)
    {
        return \Response::json($this->repo->getReport($reportName, $request->all(), $request->query('perPage')), 200);
    }
}
