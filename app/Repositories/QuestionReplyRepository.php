<?php

namespace App\Repositories;

use App\Models\QuestionReply;
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;

class QuestionReplyRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new QuestionReply();
    }

    public function store(array $params)
    {
        return $this->model->create($params);
    }

    public function update(array $params, QuestionReply $questionReply)
    {
        $questionReply->update($params);
        return $questionReply->refresh();
    }

    public function destroy(QuestionReply $questionReply)
    {
        $questionReply->delete();
    }
}
