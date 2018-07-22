<?php namespace App\Modules\Core\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class SettingRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Core\Settings';
	}

    /**
     * Save list of settings.
     *
     * @param  array   $data
     * @return void
     */
    public function saveMany(array $data)
    {
    	\DB::transaction(function () use ($data) {
    		foreach ($data as $key => $value) 
    		{
    			$this->save($value);
    		}
    	});
    }
}
