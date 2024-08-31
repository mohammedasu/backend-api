<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuestionBankRepository;

class QuestionBankService
{
    protected $repository;

    public function __construct()
    {
        $this->repository       = new QuestionBankRepository();
        $this->masterService    = new MasterService();
    }

    /**
     * Function to fetch all question bank detail list
    */

    public function getAll($request)
    {
        Log::info('QuestionBankService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }
    /**
     * Function to fetch details to add Question Bank
    */
    public function create()
    {
        Log::info('QuestionBankService | create');
        $response['question_type'] = $this->masterService->fetchQuestionBankTypes();
        return $response;
    }

    /**
     * Function to store Question Bank details
    */

    public function store($request)
    {
        Log::info('QuestionBankService | store',$request->all());
        try {
            $params = $this->CreateRequest($request);
            return $this->repository->store($params);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to store Multiple Question Bank details
    */

    public function storeMultiple($questions)
    {
        Log::info('QuestionBankService | storeMultiple',$questions);
        try {
            foreach ($questions as $key => $val) {
                if(!isset($val['id'])){
                    $where = ['question'=>$val['question'],'question_type'=>$val['question_type'],'correct_option'=>$val['correct_option']];
                    $ques = $this->repository->findByMultipleFields($where);
                    $res = [
                        'question'      =>$val['question'], 
                        'question_type' =>$val['question_type'], 
                        'options'       =>json_encode($val['options']), 
                        'correct_option'=>$val['correct_option'], 
                        'is_mandatory'  =>$val['is_mandatory']
                    ];
                    if(is_null($ques)){
                        $data = $this->repository->store($res);
                        $questions[$key]['id'] = $data->id;
                    }else{
                        $data = $this->repository->update($res, $ques);
                        $questions[$key]['id'] = $data->id;
                    }
                }
            }
            return $questions;
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to update Question Bank details
    */

    public function update($request, $questionBank)
    {
        Log::info('QuestionBankService | update',$request->all());
        try {
            $params = $this->CreateRequest($request);
            return $this->repository->update($params, $questionBank);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to create request data for Question Bank details
    */

    public function CreateRequest($request)
    {
        return [
            'question'      => $request->question,
            'question_type' => $request->question_type,
            'options'       => $request->options,
            'correct_option'=> $request->correct_option,
            'is_mandatory'  => $request->is_mandatory ?? 0,
            // 'status'        => $request->status ?? 0,
        ];
    }

    /**
     * Function to delete Question Bank details
    */
    public function destroy($questionBank)
    {
        Log::info('QuestionBankService | delete');
        try {
            $this->repository->destroy($questionBank);
            return true;
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

}
