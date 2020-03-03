<?php

namespace App\Modules\DummyModule\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DummyResource extends JsonResource
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
            // Add attributes here
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
