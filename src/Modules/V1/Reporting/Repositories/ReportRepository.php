<?php namespace App\Modules\V1\Reporting\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class ReportRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Reporting\Report';
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
            \ErrorHandler::notFound('report');
        }

        if ( ! \Core::users()->can($report->view_name, 'reports'))
        {
            \ErrorHandler::noPermissions();
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
            \ErrorHandler::notFound('report');
        }
        
        if ( ! \Core::users()->can($report->view_name, 'reports'))
        {
            \ErrorHandler::noPermissions();
        }
		
        return \DB::table($report->view_name)->get();  
    }
}
