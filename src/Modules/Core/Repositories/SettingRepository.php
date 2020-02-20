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
        return 'App\Modules\Core\Setting';
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
            foreach ($data as $value) {
                $this->save($value);
            }
        });
    }
}
