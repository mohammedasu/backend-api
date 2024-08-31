<?php

namespace App\Http\Resources\QuestionReply;

use App\Traits\ResourcePaginationTrait;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionReplyCollection extends ResourceCollection
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
            'data'      => QuestionReplyResource::collection($this->collection),
        ];
        if (!$request->has('nopagination')) {
            $pagination = $this->getPagination();
            return array_merge($collection, $pagination);
        }
        return $collection;
    }
}
