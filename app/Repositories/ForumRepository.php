<?php

namespace App\Repositories;

use App\Models\Forum;
use App\Constants\Constants;
use App\Helpers\DatabaseHelper;;

class ForumRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = new Forum();
    }

    public function getAll($request, $filter = null, $search = null)
    {
        $search_column = 'name';
        if ($request->has('nopagination')) {
            return DatabaseHelper::dataWithoutPagination($this->model, $filter, $search, $search_column);
        } else {
            return DatabaseHelper::dataWithPagination($this->model, $filter, $search, $search_column);
        }
    }
    public function findByMultipleFields($where_clause, $multiple = false)
    {
        if ($multiple) {
            return $this->model->where($where_clause)->paginate(Constants::PAGINATION_LENGTH);
        } else {
            return $this->model->where($where_clause)->first();
        }
    }
    public function fetchAllWithRelation($relationship)
    {
        return $this->model::with($relationship)->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
    }
    public function create($params)
    {
        return $this->model->create($params);
    }
    public function update(array $params, array $where_clause)
    {
        $entity = $this->model->where($where_clause)->first();

        if (!empty($entity)) {
            $entity->update($params);
            return $entity->refresh();
        }
    }
    public function destroy($where_clause)
    {
        return $this->model->where($where_clause)->delete();
    }

    public function updateWithTrashed($params, $where_clause)
    {

        $entity = $this->model::withTrashed()->where($where_clause)->first();

        if (!empty($entity)) {
            $entity->update($params);
            return $entity->refresh();
        }
    }
    public function restore($params)
    {
        $data = $this->model::withTrashed()->find($params['id']);
        $data->deleted_at = null;
        $data->restore();
        return $data;
    }
}
