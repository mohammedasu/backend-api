<?php

namespace App\Repositories;

use App\Models\Question;
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;

class QuestionRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Question();
    }

    public function getAll($request)
    {
        $questions =  $this->model->whereHas('reference',function($q) use ($request){
                        if($request->has('reference_type') AND $request->has('reference_id')){
                            return $q->where([
                                'refrence_type' => $request->reference_type,
                                'reference_id'  => $request->reference_id
                            ]);
                        }
                    });
        if($request->has('nopagination')){
            return $questions->get();
        }
        return $questions->paginate(Constants::PAGINATION_LENGTH);
    }

    public function update(array $params, Question $question)
    {
        $question->update($params);
        return $question->refresh();
    }

    public function destroy(Question $question)
    {
        $question->delete();
    }
}
