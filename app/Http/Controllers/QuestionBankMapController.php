<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\QuestionBankMap;
use App\Http\Requests\Cme\CmeQuestionImportRequest;
use App\Services\QuestionBankMapService;

class QuestionBankMapController extends Controller
{
    private $questionBankMapService;

    /**
     * @return void
     */
    public function __construct(){
       $this->questionBankMapService = new QuestionBankMapService();
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(QuestionBankMap $questionBankMap)
    {
        $response = $this->questionBankMapService->destroy($questionBankMap);
        return ApiResponse::successResponse('Mapped Question has been deleted successfully.');
    }

    /**
     * import the csv file for question bank.
     *
     */
    public function importQuestions(CmeQuestionImportRequest $request)
    {
        $response = $this->questionBankMapService->importQuestions($request);
        return ApiResponse::successResponse('Questions has been imported successfully.',$response);
    }

}
