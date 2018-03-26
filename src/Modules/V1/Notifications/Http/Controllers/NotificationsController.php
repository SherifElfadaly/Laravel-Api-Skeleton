<?php
namespace App\Modules\V1\Notifications\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Modules\V1\Core\Http\Controllers\BaseApiController;

class NotificationsController extends BaseApiController
{
    /**
     * The name of the model that is used by the base api controller 
     * to preform actions like (add, edit ... etc).
     * @var string
     */
    protected $model            = 'notifications';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['markAsRead', 'markAllAsRead', 'list', 'unread'];

    /**
     * Retrieve all notifications of the logged in user.
     * 
     * @param  integer $perPage Number of rows per page default all data.
     * @return \Illuminate\Http\Response
     */
    public function list($perPage = 0)
    {
        return \Response::json($this->repo->list($perPage), 200);
    }

    /**
     * Retrieve unread notifications of the logged in user.
     * 
     * @param  integer $perPage Number of rows per page default all data.
     * @return \Illuminate\Http\Response
     */
    public function unread($perPage = 0)
    {
        return \Response::json($this->repo->unread($perPage), 200);
    }

    /**
     * Mark the notification as read.
     * 
     * @param  integer  $id Id of the notification.
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        return \Response::json($this->repo->markAsRead($id), 200);
    }

    /**
     * Mark all notifications as read.
     * 
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        return \Response::json($this->repo->markAllAsRead(), 200);
    }
}
