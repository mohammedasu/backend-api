<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Request;
use App\Http\Resources\QuestionReply\QuestionReplyCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question'      => $this->question,
            'status'        => $this->status,
            'reported_spam' => $this->reported_spam,
            'reference'     => $this->reference,
            'member'        => $this->member,
            'replies'       => new QuestionReplyCollection($this->replies),
            // 'feedback'      => $this->feedback,
        ];
    }
}
