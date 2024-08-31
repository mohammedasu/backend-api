<?php

namespace App\Http\Resources\NotificationMaster;

use App\Http\Resources\NotificationMaster\NotificationMasterResource;
use App\Traits\ResourcePaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationMasterCollection extends ResourceCollection
{
    use ResourcePaginationTrait;

    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $collection = [
            'data'      => NotificationMasterResource::collection($this->collection),
        ];
        if(!$request->has('nopagination')){
            $pagination = $this->getPagination();
            return array_merge($collection, $pagination);
        }
        return $collection;
    }
}
