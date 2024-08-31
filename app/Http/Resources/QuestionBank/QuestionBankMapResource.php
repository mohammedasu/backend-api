<?php

namespace App\Http\Resources\QuestionBank;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionBankMapResource extends JsonResource
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
            'id'                    => $this->id,
            'map_type'              => $this->map_type,
            'show_answer'           => $this->show_answer,
            'show_answer_details'   => $this->show_answer_details,
            'question_bank_id'      => $this->question_bank_id,
            'question_details'      => new QuestionBankResource($this->question_details),
        ];
    }
}
