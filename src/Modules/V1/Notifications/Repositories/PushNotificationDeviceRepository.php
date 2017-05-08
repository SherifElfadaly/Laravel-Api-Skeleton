<?php namespace App\Modules\V1\Notifications\Repositories;

use App\Modules\V1\Core\AbstractRepositories\AbstractRepository;

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
     * Broadcast the message to the given users devices.
     *
     * @param  array  $users_ids
     * @param  string $messageText
     * @return void
     */
    public function broadcast($users_ids, $messageText)
    {
        $devicesArray = [];
        $devices      = $this->model->whereIn('user_id', $users_ids)->get();
        foreach ($devices as $device) 
        {
            $devicesArray[$device->device_type][] = \PushNotification::Device($device->device_token);
        }
        
        if (array_key_exists('ios', $devicesArray)) 
        {
            $message = $this->constructMessage($messageText, [ 'badge' => 15, 'sound' => 'default', 'content-available' => 1 ]);
            $iosDevices = \PushNotification::DeviceCollection($devicesArray['ios']);
            $this->push('ios', $iosDevices, $message);
        }

        if (array_key_exists('android', $devicesArray)) 
        {
            $message = $this->constructMessage($messageText);
            $androidDevices = \PushNotification::DeviceCollection($devicesArray['android']);
            $this->push('android', $androidDevices, $message);
        }
    }


    /**
     * Push the given message to the given devices.
     *
     * @param  string    $type
     * @param  colletion $devices
     * @param  string    $message
     * @return object
     */
    public function push($type, $devices, $message)
    {
        $collection = \PushNotification::app($type)->to($devices)->send($message);
        foreach ($collection->pushManager as $push) 
        {
            $response[] = $push->getAdapter()->getResponse();
        }
        dd($response);
    }

    /**
     * Construct the notification message.
     *
     * @param  string $messageText
     * @param  array  $options
     * @return object
     */
    protected function constructMessage($messageText, $options = [])
    {
        return \PushNotification::Message($messageText, $options);
    }
}
