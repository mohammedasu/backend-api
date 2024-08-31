<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\Cases\CasesCollection;
use App\Http\Resources\Cases\CasesResource;
use App\Services\CaseCommentService;
use App\Services\CaseQuestionService;
use App\Services\CaseService;
use Illuminate\Http\Request;
use App\Http\Requests\Cases\storeCaseRequest;

class CaseController extends Controller
{

    public function __construct() {

        // $this->middleware('permission:case', ['only' => ['index']]);
        $this->middleware('permission:add-case', ['only' => ['store']]);
        $this->middleware('permission:edit-case', ['only' => ['show','update']]);
        $this->middleware('permission:delete-case|restore-case', ['only' => ['destroy']]);
        $this->middleware('permission:update-case-status', ['only' => ['toggleStatus']]);

        $this->case_service = new CaseService();
        $this->case_question_service = new CaseQuestionService();
        $this->case_comment_service = new CaseCommentService();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $cases = $this->case_service->getCases($request);
        
        return ApiResponse::successResponse('Get All Cases', new CasesCollection($cases));
    }

    /**
     * Show the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Case $id
     */
    public function show(Request $request, $id)
    {
        $cases = $this->case_service->show($id);
        
        return ApiResponse::successResponse('Show Case Successfully', new CasesResource($cases));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeCaseRequest $request)
    {

        $cases = $this->case_service->store($request);
        
        return ApiResponse::successResponse('Add Case Successfully', new CasesResource($cases));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Cases $cases
     */
    public function update(storeCaseRequest $request, $id)
    {
        $request['id'] = $id;
        $cases = $this->case_service->update($request);
        
        return ApiResponse::successResponse('Update Case Successfully', new CasesResource($cases));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Models\Cases $case_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $case = $this->case_service->destroy($id);
        
        return ApiResponse::successResponse('Case deleted successfully');
    }

    public function toggleStatus(Request $request)
    {
        $cases = $this->case_service->updateStatus($request);
        
        return ApiResponse::successResponse('Case Status Updated Successfully');
    }

    public function commentStatus(Request $request)
    {
        $cases = $this->case_comment_service->updateStatus($request);
        
        return ApiResponse::successResponse('Case Comment Status Updated Successfully');
    }

    public function destroyCaseQuestion(Request $request, $id)
    {
        $case = $this->case_question_service->destroy($id);
        
        return ApiResponse::successResponse('Case deleted successfully');
    }

    public function download($case_id)
    {
        $images = $this->case_service->download($case_id);
        if (!$images) {
            return ApiResponse::failureResponse('Error in downloading case images.');
        }
        return ApiResponse::successResponse('Csae Images downloaded successfully.', $images);
    }

    
}
