<?php

namespace App\Modules\Acl\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Acl\Http\Resources\AclUser as UserResource;
use App\Modules\Acl\Http\Resources\AclPermission as PermissionResource;

class AclGroup extends JsonResource
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
            'name' => $this->name,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
