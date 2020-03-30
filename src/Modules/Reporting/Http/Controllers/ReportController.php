<?php

namespace App\Modules\Reporting\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Reporting\Services\ReportService;
use App\Modules\Reporting\Http\Resources\View as ViewResource;

class ReportController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Reporting\Http\Resources\Report';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['getReport'];

    /**
     * Init new object.
     *
     * @param   ReportService $service
     * @return  void
     */
    public function __construct(ReportService $service)
    {
        parent::__construct($service);
    }

    /**
     * Render the given servicert name with the given conditions.
     *
     * @param Request $request
     * @param  string $reportName Name of the requested servicert
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request, $reportName)
    {
        return new ViewResource($this->service->getReport($reportName, $request->all(), $request->query('perPage')));
    }
}
