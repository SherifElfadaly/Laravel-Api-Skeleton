<?php namespace App\Modules\V1\Core\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

class SettingRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\V1\Core\Settings';
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
