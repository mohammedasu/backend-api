<?php

namespace App\Http\Resources\CaseComment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaseCommentResource extends JsonResource
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
            'id'                => $this->id,
            'comment'           => $this->comment,
            'replies'           => $this->case_replies,
            'member'            => $this->case_users,
            'comment_user_id'   => $this->comment_user_id,
            'comment_user_type' => $this->comment_user_type,
            'is_approved'       => $this->is_approved,
            'has_child'         => $this->has_child,
            'likes'             => $this->likes,
        ];
    }
}
