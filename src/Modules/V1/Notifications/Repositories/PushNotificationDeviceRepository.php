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
     * Set the notification notified to all.
     *
     * @param  array  $users_ids
     * @param  string $messageText
     * @return void
     */
    public function broadcast($users_ids, $messageText)
    {
		$devicesArray = [];
		$devices      = \Core::notifications()->model->whereIn('user_id', $users_ids);
    	foreach ($devices as $device) 
    	{
    		$devicesArray[$device->deivce_type] = \PushNotification::Device($device->device_token, array('badge' => 5));
    	}
    	
		$androidDevices = \PushNotification::DeviceCollection($devicesArray['ios']);
		$iosDevices     = \PushNotification::DeviceCollection($devicesArray['android']);
		$message        = constructMessage($messageText);

		$this->push('android', $androidDevices, $message);
		$this->push('ios', $iosDevices, $message);
    }


 	/**
     * Set the notification notified to true.
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
    	$message = \PushNotification::Message($messageText, $options);
    }
}
