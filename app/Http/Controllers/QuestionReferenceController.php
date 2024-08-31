<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\QuestionReferenceService;
use App\Http\Resources\QuestionReference\QuestionReferenceCollection;

class QuestionReferenceController extends Controller
{
    private $questionReferenceService;

    /**
     * @return void
     */
    public function __construct(){
       $this->questionReferenceService  = new QuestionReferenceService();
    }

    /**
     * Display a listing of the resource.
     *
    */

    public function index(Request $request)
    {
        $questionReferenceList = $this->questionReferenceService->getAll($request);
        return ApiResponse::successResponse('Reference list of questions has been fetched successfully.', new QuestionReferenceCollection($questionReferenceList));
    }

}
