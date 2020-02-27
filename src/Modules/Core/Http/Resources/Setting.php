<?php

namespace App\Modules\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = true;

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
            'value' => $this->value,
            'key' => $this->key,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
