<?php

namespace App\Modules\Permissions\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Roles\Http\Resources\Role as RoleResource;

class Permission extends JsonResource
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
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
