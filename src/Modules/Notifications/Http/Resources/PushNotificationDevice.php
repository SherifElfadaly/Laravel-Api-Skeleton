<?php

namespace App\Modules\Notifications\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Acl\Http\Resources\AclUser as UserResource;

class PushNotificationDevice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'device_token' => $this->device_token,
            'access_token' => $this->access_token,
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
