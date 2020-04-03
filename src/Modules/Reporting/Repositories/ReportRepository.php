<?php

namespace App\Modules\Reporting\Repositories;

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
     * @param  mixed   $report
     * @param  array   $conditions
     * @param  integer $perPage
     * @return object
     */
    public function renderReport($report, $conditions = [], $perPage = 0)
    {
        $report = ! is_int($report) ? $report : $this->find($report);
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
