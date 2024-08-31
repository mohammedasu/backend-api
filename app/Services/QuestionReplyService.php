<?php

namespace App\Services;

use App;
use App\Constants\Constants;
use Illuminate\Support\Facades\Log;
use App\Repositories\QuestionReplyRepository;

class QuestionReplyService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new QuestionReplyRepository();
    }

    /**
     * Function to store Question Reply details
    */

    public function store($request)
    {
        Log::info('QuestionReplyService | store',$request->all());
        try {
            return $this->repository->store($this->CreateRequest($request));

        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to update Question Reply details
    */

    public function update($request, $questionReply)
    {
        Log::info('QuestionReplyService | update',$request->all());
        try {
            return $this->repository->update(['reported_spam'=>$request->report_spam], $questionReply);
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * Function to create request data for Question Reply details
    */

    public function CreateRequest($request)
    {
        return [
            'member_id'     => auth('api')->user()->id,
            'member_type'   => config('constants.QUESTIONS_USER_TYPE')['ADMIN'],
            'reply'         => $request->reply,
            'question_id'   => $request->question_id,
            'parent_id'     => $request->parent_id ?? null
        ];
    }


    /**
     * Function to delete Question Reply details
    */
    public function destroy($questionReply)
    {
        Log::info('QuestionReplyService | delete');
        try {
            $this->repository->destroy($questionReply);
            return true;
        } catch (Exception $e){
            throw new Exception($e);
        }
    }

}
