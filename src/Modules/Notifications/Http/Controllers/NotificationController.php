<?php

namespace App\Modules\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Core\BaseClasses\BaseApiController;
use App\Modules\Notifications\Services\NotificationService;
use App\Modules\Core\Http\Resources\General as GeneralResource;

class NotificationController extends BaseApiController
{
    /**
     * Path of the model resource
     *
     * @var string
     */
    protected $modelResource = 'App\Modules\Notifications\Http\Resources\Notification';

    /**
     * List of all route actions that the base api controller
     * will skip permissions check for them.
     * @var array
     */
    protected $skipPermissionCheck = ['markAsRead', 'markAllAsRead', 'index', 'unread'];

    /**
     * Init new object.
     *
     * @param   NotificationService $service
     * @return  void
     */
    public function __construct(NotificationService $service)
    {
        parent::__construct($service);
    }

    /**
     * Retrieve all notifications of the logged in user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->modelResource::collection($this->service->my($request->query('perPage')));
    }

    /**
     * Retrieve unread notifications of the logged in user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function unread(Request $request)
    {
        return $this->modelResource::collection($this->service->unread($request->query('perPage')));
    }

    /**
     * Mark the notification as read.
     *
     * @param  integer  $id Id of the notification.
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        return new GeneralResource($this->service->markAsRead($id));
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        return new GeneralResource($this->service->markAllAsRead());
    }
}
