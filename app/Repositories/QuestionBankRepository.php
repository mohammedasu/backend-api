<?php

namespace App\Repositories;

use App\Models\QuestionBank;
use App\Constants\Constants;

class QuestionBankRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new QuestionBank();
    }

    public function getAll($request)
    {
        $questions = $this->model->query();
        if($request->has('search')){
            $questions->where('question','like','%'. $request->search.'%');
        }
        if($request->has('nopagination')){
            return $questions->orderBy('id', 'desc')->get();
        }
        return $questions->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
    }

    public function findByMultipleFields($where_clause, $multiple = false)
    {
        if ($multiple) {
            return $this->model->where($where_clause)->paginate(Constants::PAGINATION_LENGTH);
        } else {
            return $this->model->where($where_clause)->first();
        }
    }

    public function store(array $params)
    {
        return $this->model->create($params);
    }

    public function update(array $params, QuestionBank $questionBank)
    {
        $questionBank->update($params);
        return $questionBank->refresh();
    }

    public function destroy(QuestionBank $questionBank)
    {
        $questionBank->delete();
    }
}
