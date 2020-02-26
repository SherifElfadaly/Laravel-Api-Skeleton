<?php

namespace App\Modules\Acl\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Modules\Acl\Http\Resources\AclGroup as GroupResource;

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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'groups' => GroupResource::collection($this->whenLoaded('groups')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
