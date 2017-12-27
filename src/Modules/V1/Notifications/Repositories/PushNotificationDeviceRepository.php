<?php namespace App\Modules\V1\Notifications\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;
use App\Modules\V1\Notifications\Jobs\PushNotifications;
use App\Modules\V1\Notifications\Jobs\PushNotificationsTopic;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

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
     * Register the given device to the logged in user.
     *
     * @param  string $data
     * @return void
     */
    public function registerDevice($data)
    {
        $data['login_token'] = \JWTAuth::parseToken()->getToken();
        $data['user_id']     = \JWTAuth::parseToken()->authenticate()->id;
        if ($device = $this->model->where('device_token', $data['device_token'])->where('user_id', $data['user_id'])->first()) 
        {
            $data['id'] = $device->id;
        }

        return $this->save($data);
    }

    /**
     * Push the given notification to the given logged in userIds.
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
            $devices             = $this->model->whereIn('user_id', $userIds)->get();
            $tokens              = [];

            foreach ($devices as $device) 
            {
                $loginToken = decrypt($device->login_token);

                try
                {
                    if (\JWTAuth::authenticate($loginToken)) 
                    {
                        $tokens[] = $device->device_token;
                    }    
                } 
                catch (\Exception $e) 
                {
                    $device->forceDelete();
                }
            }

            if (count($tokens)) 
            {
                dispatch(new PushNotifications($option, $notification, $data, $tokens));
            }
        }
    }

    /**
     * Push the given notification to the given topic.
     *
     * @param  string $topicName
     * @param  string $title
     * @param  string $message
     * @return void
     */
    public function pushTopic($topicName, $title, $message)
    {
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($message)->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($topicName);

        dispatch(new PushNotificationsTopic($topic, $notification));
    }
}
