<?php

namespace App\Modules\Reporting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class View extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [$this->resource];
    }
}
