<?php

namespace App\Modules\Notifications\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Acl\Http\Resources\AclUser as UserResource;

class PushNotificationDevice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'deviceToken' => $this->device_token,
            'accessToken' => $this->access_token,
            'user' => new UserResource($this->whenLoaded('user')),
            'timeZone' => $this->time_zone,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
