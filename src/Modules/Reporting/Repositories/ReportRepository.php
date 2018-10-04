<?php namespace App\Modules\Reporting\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class ReportRepository extends AbstractRepository
{
    /**
     * Return the model full namespace.
     * 
     * @return string
     */
    protected function getModel()
    {
        return 'App\Modules\Reporting\Report';
    }

    /**
     * Render the given report db view based on the given
     * condition.
     *
     * @param  string  $reportName
     * @param  array   $conditions array of conditions
     * @param  integer $perPage
     * @param  array   $relations
     * @param  boolean   $skipPermission
     * @return object
     */
    public function getReport($reportName, $conditions = false, $perPage = 0, $relations = [], $skipPermission = false)
    {
        /**
         * Fetch the report from db.
         */
        $reportConditions = $this->constructConditions(['report_name' => $reportName], $this->model);
        $report           = call_user_func_array("{$this->getModel()}::with", array($relations))->whereRaw($reportConditions['conditionString'], $reportConditions['conditionValues'])->first();
        
        /**
         * Check report existance and permission.
         */
        if ( ! $report) 
        {
            \ErrorHandler::notFound('report');
        }
        else if (! $skipPermission && ! \Core::users()->can($report->view_name, 'reports'))
        {
            \ErrorHandler::noPermissions();
        }

        /**
         * Fetch data from the report based on the given conditions.
         */
        $report = \DB::table($report->view_name);
        unset($conditions['page']);
        if (count($conditions))
        {
            $conditions = $this->constructConditions($conditions, $this->model);
            $report->whereRaw($conditions['conditionString'], $conditions['conditionValues']);   
        }
        /**
         * Paginate or all data.
         */
        if ($perPage) 
        {
            return $report->paginate($perPage);
        }
        else
        {
            return $report->get();  
        }
    }
}
