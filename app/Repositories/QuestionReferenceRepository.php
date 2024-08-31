<?php

namespace App\Repositories;

use App\Models\ReferenceQuestion;
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;

class QuestionReferenceRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new ReferenceQuestion();
    }

    public function getAll($request)
    {
        $references =  $this->model->whereHas('questions')
                    ->select('reference_id','refrence_type',DB::raw('count(*) as total_questions'))
                    ->groupBy('refrence_type')
                    ->groupBy('reference_id');

        if($request->has('nopagination')){
            return $references->get();
        }
        return $references->paginate(Constants::PAGINATION_LENGTH);
    }

}
