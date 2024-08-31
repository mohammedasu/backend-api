<?php

namespace App\Http\Controllers;

use App\Models\QuestionBank;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\QuestionBankService;
use App\Http\Requests\QuestionBank\QuestionBankStoreRequest;
use App\Http\Requests\QuestionBank\QuestionBankUpdateRequest;
use App\Http\Resources\QuestionBank\QuestionBankResource;
use App\Http\Resources\QuestionBank\QuestionBankCollection;

class QuestionBankController extends Controller
{
    private $questionBankService;

    /**
     * @return void
     */
    public function __construct(){
        $this->middleware('permission:question-bank', ['only' => ['index']]);
        $this->middleware('permission:add-question-bank', ['only' => ['store']]);
        $this->middleware('permission:edit-question-bank', ['only' => ['show','update']]);
        $this->middleware('permission:delete-question-bank', ['only' => ['destroy']]);
        $this->questionBankService = new QuestionBankService();
    }

    /**
     * Display a listing of the resource.
     *
    */

    public function index(Request $request)
    {
        $questionBankList = $this->questionBankService->getAll($request);
        return ApiResponse::successResponse('Question Bank List has been fetched successfully.', new QuestionBankCollection($questionBankList));
    }

    /**
     * Store a newly created resource in storage.
     *
    */
    public function store(QuestionBankStoreRequest $request)
    {
        $questionBank = $this->questionBankService->store($request);
        return ApiResponse::successResponse('Question Bank has been added successfully.',new QuestionBankResource($questionBank));
    }

    /**
     * Display the specified resource.
     *
    */
    public function show(QuestionBank $questionBank)
    {
        return ApiResponse::successResponse('Question Bank Details has been fetched successfully.', new QuestionBankResource($questionBank));
    }

    /**
     * Update the specified resource in storage.
     *
    */
    public function update(QuestionBankUpdateRequest $request, QuestionBank $question_bank)
    {
        $question_bank = $this->questionBankService->update($request, $question_bank);
        return ApiResponse::successResponse('Question Bank has been updated successfully.',new QuestionBankResource($question_bank));
    }

    /**
     * Remove the specified resource from storage.
     *
    */
    public function destroy(QuestionBank $questionBank)
    {
        $response = $this->questionBankService->destroy($questionBank);
        return ApiResponse::successResponse('Question Bank has been deleted successfully.');
    }
}