<?php

namespace App\Modules\Reporting\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Report extends JsonResource
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
            'report_name' => $this->report_name,
            'view_name' => $this->view_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
