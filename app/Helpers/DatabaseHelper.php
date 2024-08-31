<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Constants\Constants;

class DatabaseHelper
{


    public static function dataWithoutPagination($model, $filter = null, $search = null, $search_column = null, $where_condition = array())
    {
        Log::info(['dataWithoutPagination' => $filter]);
        if ($search) {
            $model = $model->where($search_column, 'LIKE', '%' . $search . '%');
        }
        if ($where_condition) {
            $model = $model->where($where_condition);
        }

        if ($filter == 'trash') {
            return $model->withTrashed()->whereNotNull('deleted_at')->orderBy('id', 'desc')->get();
        } else if ($filter == 'active') {
            return $model->active()->orderBy('id', 'desc')->get();
        } else if ($filter == 'visible_in_cases') {  // for expert using this 
            return $model->active()->where('visible_in_cases', 1)->orderBy('id', 'desc')->get();
        } else {
            return $model->whereNull('deleted_at')->orderBy('id', 'desc')->get();
        }
    }
    public static function dataWithPagination($model, $filter = null, $search = null, $search_column = null, $where_condition = array())
    {
        Log::info(['dataWithoutPagination' => $filter]);
        if ($search) {
            $model = $model->where($search_column, 'LIKE', '%' . $search . '%');
        }
        if ($where_condition) {
            $model = $model->where($where_condition);
        }
        if ($filter == 'trash') {
            return $model->withTrashed()->whereNotNull('deleted_at')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        } else if ($filter == 'active') {
            return $model->active()->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        } else {
            return $model->whereNull('deleted_at')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);;
        }
    }
}
