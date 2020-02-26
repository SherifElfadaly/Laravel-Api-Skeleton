<?php

namespace App\Modules\Core\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class General extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return ['status' => $this->resource ?? 'success'];
    }
}
