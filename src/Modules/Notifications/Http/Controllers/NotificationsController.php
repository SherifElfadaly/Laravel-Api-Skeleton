<?php
namespace App\Modules\Notifications\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\Core\Http\Controllers\BaseApiController;

class NotificationsController extends BaseApiController
{
	/**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model            = 'notifications';

    /**
     * Set the notification notified to true.
     * 
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function getNotified($id)
    {
        return \Response::json(\Core::notifications()->notified($id), 200);
    }

    /**
     * Set the notification notified to all.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getNotifyall()
    {
        return \Response::json(\Core::notifications()->notifyAll(), 200);
    }
}
