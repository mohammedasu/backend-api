<?php

namespace App\Services;

use App;
use App\Constants\Constants;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuestionRepository;

class QuestionService
{
    protected $repository;

    public function __construct()
    {
        $this->repository       = new QuestionRepository();
    }

    /**
     * Function to fetch all question detail list
    */

    public function getAll($request)
    {
        Log::info('QuestionService | getAll', $request->all());
        try {
            return $this->repository->getAll($request);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to update Question Bank details
    */

    public function update($request, $question)
    {
        Log::info('QuestionService | update',$request->all());
        try {
            return $this->repository->update(['reported_spam'=>$request->report_spam], $question);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to delete Question Bank details
    */
    public function destroy($question)
    {
        Log::info('QuestionService | delete');
        try {
            $this->repository->destroy($question);
            return true;
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

}
