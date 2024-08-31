<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Constants\Constants;

class MciHelper
{

    public static function dataWithPagination($model, $filter = null, $search = null, $where_condition = array())
    {
        // dd($model);
        Log::info(['dataWithoutPagination' => $filter]);
        if ($search) {
            $model = $model->where('mobile_number', 'LIKE', '%' . $search . '%')
                            ->orWhere('fname', 'LIKE', '%' . $search . '%')
                            ->orWhere('lname', 'LIKE', '%' . $search . '%');
        }
        if ($where_condition) {
            $model = $model->where($where_condition);
        }
        if($filter == 'without'){
            return $model->with(['mci_member_document' => function($q){
                $q->whereNull('mci_document');
                $q->orWhere('mci_document', 'null');
            }])->where('is_verified_with_mci', '=', '1')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }else if($filter == 'with'){
            return $model->whereHas('mci_member_document',function($q){
                $q->where('is_documents_verified', '=', '1');
            })->where('is_verified_with_mci', '=', '1')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }else if ($filter == 'processing') {
                return $model->where('is_verified_with_mci', '=', '3')->orWhere('is_verified_with_mci', '=', '2')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }else if($filter == 'pending'){
            return $model->where('is_verified_with_mci', '=', '4')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }else if($filter == 'call'){
            return $model->whereHas('mci_member_document',function($q){
                $q->where('no_document', '=', '1');
            })->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }
        else if($filter == 'not-valid'){
            return $model->where('is_verified_with_mci', '=', '5')->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }else{
            return $model->orderBy('id', 'desc')->paginate(Constants::PAGINATION_LENGTH);
        }
    }
}
