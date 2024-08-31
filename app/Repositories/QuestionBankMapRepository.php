<?php

namespace App\Repositories;

use App\Models\QuestionBankMap;

class QuestionBankMapRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new QuestionBankMap();
    }

    public function storeMultiple(array $params)
    {
        return $this->model->insert($params);
    }

    public function update(array $params,$mapped_id)
    {
        return $this->model->where('id',$mapped_id)->update($params);
    }

    public function destroy(QuestionBankMap $questionBankMap)
    {
        return $questionBankMap->delete();
    }

}
