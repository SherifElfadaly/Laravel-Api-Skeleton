<?php
namespace App\Modules\Notifications\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;

class PushNotificationsDevicesController extends BaseApiController
{
	/**
	 * The name of the model that is used by the base api controller 
	 * to preform actions like (add, edit ... etc).
	 * @var string
	 */
	protected $model            = 'pushNotificationDevices';

	/**
	 * List of all route actions that the base api controller
	 * will skip permissions check for them.
	 * @var array
	 */
	protected $skipPermissionCheck = ['registerDevice'];

	/**
	 * The validations rules used by the base api controller
	 * to check before add.
	 * @var array
	 */
	protected $validationRules  = [
	'device_token' => 'required|string|max:255',
	'user_id'      => 'required|exists:users,id'
	];

	/**
	 * Register the given device to the logged in user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function registerDevice(Request $request)
	{
		$this->validate($request, [
			'device_token' => 'required|string|max:255'
			]);

		return \Response::json($this->repo->registerDevice($request->all()), 200);
	}
}
