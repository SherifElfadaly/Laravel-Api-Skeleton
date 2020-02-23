<?php namespace App\Modules\Reporting\Repositories;

use App\Modules\Core\BaseClasses\BaseRepository;
use App\Modules\Reporting\Report;

class ReportRepository extends BaseRepository
{
    /**
     * Init new object.
     *
     * @param   Report $model
     * @return  void
     */
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }

    /**
     * Render the given report db view based on the given
     * condition.
     *
     * @param  string  $reportName
     * @param  array   $conditions
     * @param  integer $perPage
     * @param  array   $relations
     * @param  boolean $skipPermission
     * @return object
     */
    public function getReport($reportName, $conditions = [], $perPage = 0, $relations = [], $skipPermission = false)
    {
        /**
         * Fetch the report from db.
         */
        $reportConditions = $this->constructConditions(['report_name' => $reportName], $this->model);
        $report           = $this->model->with($relations)
        ->whereRaw(
            $reportConditions['conditionString'],
            $reportConditions['conditionValues']
        )->first();
        
        /**
         * Check report existance and permission.
         */
        if (! $report) {
            \ErrorHandler::notFound('report');
        } elseif (! $skipPermission && ! \Core::users()->can($report->view_name, 'reports')) {
            \ErrorHandler::noPermissions();
        }

        /**
         * Fetch data from the report based on the given conditions.
         */
        $report = \DB::table($report->view_name);
        unset($conditions['page']);
        if (count($conditions)) {
            $conditions = $this->constructConditions($conditions, $this->model);
            $report->whereRaw($conditions['conditionString'], $conditions['conditionValues']);
        }
        /**
         * Paginate or all data.
         */
        if ($perPage) {
            return $report->paginate($perPage);
        } else {
            return $report->get();
        }
    }
}
