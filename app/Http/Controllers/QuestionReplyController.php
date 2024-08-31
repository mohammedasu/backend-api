<?php

namespace App\Http\Controllers;

use App\Models\QuestionReply;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\QuestionReplyService;
use App\Http\Requests\QuestionReply\QuestionReplyStoreRequest;
use App\Http\Resources\QuestionReply\QuestionReplyResource;

class QuestionReplyController extends Controller
{
    private $questionReplyService;

    /**
     * @return void
     */
    public function __construct(){
       $this->questionReplyService = new QuestionReplyService();
    }

    /**
     * Store a newly created resource in storage.
     *
    */
    public function store(QuestionReplyStoreRequest $request)
    {
        $questionReply = $this->questionReplyService->store($request);
        return ApiResponse::successResponse('Question Reply has been added successfully.',new QuestionReplyResource($questionReply));
    }

    /**
     * Update the specified resource in storage.
     *
    */
    public function update(Request $request, QuestionReply $questionReply)
    {
        $request->mergeIfMissing(['nopagination' => 1]);
        $questionReply = $this->questionReplyService->update($request, $questionReply);
        return ApiResponse::successResponse('Question Reply has been updated successfully.',new QuestionReplyResource($questionReply));
    }

    /**
     * Remove the specified resource from storage.
     *
    */
    public function destroy(QuestionReply $questionReply)
    {
        $response = $this->questionReplyService->destroy($questionReply);
        return ApiResponse::successResponse('Question Reply has been deleted successfully.');
    }
}
