<?php

namespace App\Modules\Acl\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Acl\Http\Resources\AclUser as UserResource;

class OauthClient extends JsonResource
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
            'name' => $this->name,
            'redirect' => $this->redirect,
            'user' => new UserResource($this->whenLoaded('user')),
            'personalAccessClient' => $this->personal_access_client,
            'passwordClient' => $this->password_client,
            'revoked' => $this->revoked,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
