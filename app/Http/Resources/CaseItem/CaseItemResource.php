<?php

namespace App\Http\Resources\CaseItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'image' => !empty($this->image_name) ? (config('constants.cases_path').$this->image_name) : null,
        ];
    }
}
