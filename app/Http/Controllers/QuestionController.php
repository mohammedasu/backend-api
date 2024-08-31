<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\QuestionService;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionCollection;

class QuestionController extends Controller
{
    private $questionService;

    /**
     * @return void
     */
    public function __construct(){
       $this->questionService = new QuestionService();
    }

    /**
     * Display a listing of the resource.
     *
    */

    public function index(Request $request)
    {
        $questionList = $this->questionService->getAll($request);
        return ApiResponse::successResponse('Question List has been fetched successfully.', new QuestionCollection($questionList));
    }

    /**
     * Display the specified resource.
     *
    */
    public function show(Request $request, Question $question)
    {
        $request->mergeIfMissing(['nopagination' => 1]);
        return ApiResponse::successResponse('Question Details has been fetched successfully.', new QuestionResource($question));
    }

    /**
     * Show the form for editing the specified resource.
     *
    */
    public function edit(Request $request, Question $question)
    {
        $request->mergeIfMissing(['nopagination' => 1]);
        return ApiResponse::successResponse('Question Details has been fetched successfully.', new QuestionResource($question));
    }

    /**
     * Update the specified resource in storage.
     *
    */
    public function update(Request $request, Question $question)
    {
        $request->mergeIfMissing(['nopagination' => 1]);
        $question = $this->questionService->update($request, $question);
        return ApiResponse::successResponse('Question has been updated successfully.',new QuestionResource($question));
    }

    /**
     * Remove the specified resource from storage.
     *
    */
    public function destroy(Question $question)
    {
        $this->questionService->destroy($question);
        return ApiResponse::successResponse('Question has been deleted successfully.');
    }
}
