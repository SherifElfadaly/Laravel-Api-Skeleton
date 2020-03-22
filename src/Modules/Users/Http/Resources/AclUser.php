<?php

namespace App\Modules\Users\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Roles\Http\Resources\Role as RoleResource;
use App\Modules\OauthClients\Http\Resources\OauthClient as OauthClientResource;
use App\Modules\Notifications\Http\Resources\Notification as NotificationResource;

class AclUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        if (! $this->resource) {
            return [];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profilePicture' => $this->profile_picture,
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
            'readNotifications' => NotificationResource::collection($this->whenLoaded('readNotifications')),
            'unreadNotifications' => NotificationResource::collection($this->whenLoaded('unreadNotifications')),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'oauthClients' => OauthClientResource::collection($this->whenLoaded('oauthClients')),
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
