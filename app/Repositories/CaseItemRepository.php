<?php

namespace App\Repositories;

use App\Models\CaseItems;
use App\Constants\Constants;
use Carbon\Carbon;

class CaseItemRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new CaseItems();
    }

    public function getAll($where)
    {
        return $this->model->where($where)->get();
    }

    public function create($request)
    {
        return $this->model->create($request);
    }

    public function destroy($where)
    {
        return $this->model->where($where)->delete();
    }
    public function fetchOne($where)
    {
        return $this->model->where($where)->first();
    }
}
