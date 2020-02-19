<?php namespace App\Modules\Notifications\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;
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
        return 'App\Modules\Notifications\PushNotificationDevice';
    }

    /**
     * Register the given device to the logged in user.
     *
     * @param  array $data
     * @return void
     */
    public function registerDevice($data)
    {
        $data['access_token'] = \Auth::user()->token();
        $data['user_id']      = \Auth::id();
        $device               = $this->model->where('device_token', $data['device_token'])->
                                              where('user_id', $data['user_id'])->
                                              first();

        if ($device) {
            $data['id'] = $device->id;
        }

        return $this->save($data);
    }

    /**
     * Generate the given message data.
     *
     * @param  string $title
     * @param  string $message
     * @param  array  $data
     * @return void
     */
    public function generateMessageData($title, $message, $data = [])
    {
        $optionBuilder       = new OptionsBuilder();
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $dataBuilder         = new PayloadDataBuilder();

        $optionBuilder->setTimeToLive(60 * 20);
        $notificationBuilder->setBody($message);
        $dataBuilder->addData($data);

        $options             = $optionBuilder->build();
        $notification        = $notificationBuilder->build();
        $data                = $dataBuilder->build();

        return compact('options', 'notification', 'data');
    }
}
