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
     * Fetch the given users devices and broadcast the given
     * message to all of them.
     *
     * @param  array   $users_ids
     * @param  string  $messageText
     * @param  boolean $activeOnly
     * @return void
     */
    public function broadcast($users_ids, $messageText, $activeOnly = false)
    {
        $devicesArray = [];
        $devices      = $this->model->whereIn('user_id', $users_ids);
        $devices      = $activeOnly ? $device->where('active', 1)->get() : $devices->get();
        foreach ($devices as $device) 
        {
            $devicesArray[$device->device_type][] = \PushNotification::Device($device->device_token, array('badge' => 5));
        }
        
        $message = $this->constructMessage($messageText);
        if (array_key_exists('ios', $devicesArray)) 
        {
            $iosDevices = \PushNotification::DeviceCollection($devicesArray['ios']);
            $this->push('ios', $iosDevices, $message);
        }

        if (array_key_exists('android', $devicesArray)) 
        {
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
     * @return void
     */
    public function push($type, $devices, $message)
    {
        $collection = \PushNotification::app($type)->to($devices)->send($message);
        foreach ($collection->pushManager as $push) 
        {
            $response[] = $push->getAdapter()->getResponse();
        }
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
