<?php

namespace App\Modules\OauthClients\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Users\Http\Resources\AclUser as UserResource;

class OauthClient extends JsonResource
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
            'redirect' => $this->redirect,
            'user' => new UserResource($this->whenLoaded('user')),
            'personalAccessClient' => $this->personal_access_client,
            'passwordClient' => $this->password_client,
            'revoked' => $this->revoked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
