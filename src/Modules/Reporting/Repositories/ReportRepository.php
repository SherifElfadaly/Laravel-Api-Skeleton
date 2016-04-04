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
        $apiVersion = \Request::header('api-version') ?: 1;
		return 'App\Modules\Reporting\Report';
	}

	/**
     * Render the given report db view.
     * 
     * @param  integer $id
     * @param  array   $relations
     * @param  array   $columns
     * @return object
     */
    public function find($id, $relations = [], $columns = array('*'))
    {
		$report = call_user_func_array("{$this->getModel()}::with", array($relations))->find($id, $columns);

        if ( ! $report) 
        {
            $error = \ErrorHandler::notFound('report');
            abort($error['status'], $error['message']);
        }

        if ( ! \Core::users()->can($report->view_name, 'reports'))
        {
            $error = \ErrorHandler::noPermissions();
            abort($error['status'], $error['message']);
        }

        return \DB::table($report->view_name)->get();
    }

    /**
     * Render the given report db view based on the given
     * condition.
     *
     * @param  array   $conditions array of conditions
     * @param  array   $relations
     * @param  array   $colunmns
     * @return object
     */
    public function first($conditions, $relations = [], $columns = array('*'))
    {
		$conditions = $this->constructConditions($conditions);
		$report     = call_user_func_array("{$this->getModel()}::with", array($relations))->whereRaw($conditions['conditionString'], $conditions['conditionValues'])->first($columns);
        
        if ( ! $report) 
        {
            $error = \ErrorHandler::notFound('report');
            abort($error['status'], $error['message']);
        }
        
        if ( ! \Core::users()->can($report->view_name, 'reports'))
        {
            $error = \ErrorHandler::noPermissions();
            abort($error['status'], $error['message']);
        }
		
        return \DB::table($report->view_name)->get();  
    }
}
