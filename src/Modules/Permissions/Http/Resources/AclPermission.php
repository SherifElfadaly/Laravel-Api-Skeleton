<?php

namespace App\Modules\Permissions\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Groups\Http\Resources\AclGroup as GroupResource;

class AclPermission extends JsonResource
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
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
