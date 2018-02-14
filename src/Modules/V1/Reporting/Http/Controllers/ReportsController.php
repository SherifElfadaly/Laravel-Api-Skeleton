<?php
namespace App\Modules\V1\Reporting\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;

class ReportsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model               = 'reports';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['getReport'];

    /**
     * Render the given report name with the given conditions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $reportName Name of the requested report
     * @param  integer $perPage    Number of rows per page default all data.
     * @return \Illuminate\Http\Response
     */
    public function getReport(Request $request, $reportName, $perPage = 0) 
    {
        if ($this->model) 
        {
            return \Response::json($this->repo->getReport($reportName, $request->all(), $perPage), 200);
        }
    }
}
