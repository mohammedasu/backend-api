<?php

namespace App\Http\Resources\QuestionBank;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionBankResource extends JsonResource
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
            'question_type' => $this->question_type,
            'options'       => $this->options,
            'correct_option'=> $this->correct_option,
            'is_mandatory'  => $this->is_mandatory ? 1 : 0,
        ];
    }
}
