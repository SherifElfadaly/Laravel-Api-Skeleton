<?php

namespace App\Modules\Roles\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Users\Http\Resources\AclUser as UserResource;
use App\Modules\Permissions\Http\Resources\Permission as PermissionResource;

class Role extends JsonResource
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
            'users' => UserResource::collection($this->whenLoaded('users')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
