<?php namespace App\Modules\V1\Notifications\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;
use App\Modules\V1\Notifications\Jobs\PushNotifications;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class PushNotificationDeviceRepository extends AbstractRepository
{
    /**
    * Return the model full namespace.
    * 
    * @return string
    */
    protected function getModel()
    {
        return 'App\Modules\V1\Notifications\PushNotificationDevice';
    }

    /**
     * Set the notification notified to all.
     *
     * @param  array  $users_ids
     * @param  string $title
     * @param  string $message
     * @param  string $data
     * @return void
     */
    public function registerDevice($data)
    {
        $data['user_id'] = \JWTAuth::parseToken()->authenticate()->id;
        if ($device = $this->model->where('device_token', $data['device_token'])->where('user_id', $data['user_id'])->first()) 
        {
            $data['id'] = $device->id;
        }

        return $this->save($data);
    }

    /**
     * Set the notification notified to all.
     *
     * @param  array  $userIds
     * @param  string $title
     * @param  string $message
     * @param  string $data
     * @return void
     */
    public function push($userIds, $title, $message, $data = [])
    {
        if (count($userIds)) 
        {
            $optionBuilder       = new OptionsBuilder();
            $notificationBuilder = new PayloadNotificationBuilder($title);
            $dataBuilder         = new PayloadDataBuilder();

            $optionBuilder->setTimeToLive(60*20);
            $notificationBuilder->setBody($message);
            $dataBuilder->addData($data);

            $option              = $optionBuilder->build();
            $notification        = $notificationBuilder->build();
            $data                = $dataBuilder->build();
            $tokens              = $this->model->whereIn('user_id', $userIds)->pluck('device_token')->toArray();

            if (count($tokens)) 
            {
                dispatch(new PushNotifications($option, $notification, $data, $tokens));
            }
        }
    }
}
