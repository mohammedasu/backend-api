<?php

namespace App\Http\Resources\QuestionReply;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionReplyResource extends JsonResource
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
            'id'            => $this->id,
            'reply'         => $this->reply,
            'member_id'     => $this->member_id,
            'member_type'   => $this->member_type,
            'question_id'   => $this->question_id,
            'parent_id'     => $this->parent_id,
            'reported_spam' => $this->reported_spam,
            'member'        => $this->member,
            'replies'       => $this->replies,
        ];
    }
}
