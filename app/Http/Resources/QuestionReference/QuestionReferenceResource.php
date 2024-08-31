<?php

namespace App\Http\Resources\QuestionReference;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionReferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $refrenceName = null;
        $refrenceLink = null;
        if($this->refrence_type == 'forum'){
            $refrenceLink = $this->forum ? '/forums/'.$this->forum->link_name : null;
            $refrenceName = $this->forum ? $this->forum->name : null;
        }elseif($this->refrence_type == 'videos'){
            $refrenceLink = $this->video ? '/video/'.base64_encode($this->video->id) : null;
            $refrenceName = $this->video ? $this->video->title : null;
        }elseif($this->refrence_type == 'cases'){
            $refrenceLink = $this->case ? '/cases/'.$this->case->id : null;
            $refrenceName = $this->case ? $this->case->title : null;
        }
        return [
            'reference_id'      => $this->reference_id,
            'reference_type'    => $this->refrence_type,
            'total_questions'   => $this->total_questions,
            'refrence_name'    => $refrenceName,
            'reference_link'    => $refrenceLink,
        ];
    }
}
