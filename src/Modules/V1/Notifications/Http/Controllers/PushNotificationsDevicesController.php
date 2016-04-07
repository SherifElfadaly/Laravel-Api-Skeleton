<?php
namespace App\Modules\V1\Notifications\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;

class PushNotificationsDevicesController extends BaseApiController
{
	/**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model            = 'notifications';

    /**
     * The validations rules used by the base api controller
     * to check before add.
     * @var array
     */
    protected $validationRules  = [
    'device_token'   => 'required|string|max:100',
    'device_type' => 'required|in:androind,ios',
    'user_id'     => 'required|exists:users,id',
    'active'      => 'boolean'
    ];
}
