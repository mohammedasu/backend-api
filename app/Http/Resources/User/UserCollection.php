<?php

namespace App\Http\Resources\User;

use App\Traits\ResourcePaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'data'      => UserResource::collection($this->collection),
        ];
        if(!$request->has('nopagination')){
            $pagination = $this->getPagination();
            return array_merge($collection, $pagination);
        }
        return $collection;
    }
}
