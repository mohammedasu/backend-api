<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\CaseItemService;
use Illuminate\Http\Request;

class CaseItemController extends Controller
{

    public function __construct()
    {

        $this->caseItemService = new CaseItemService();
    }

    public function destroyCaseImage(Request $request, $id)
    {
        $case = $this->caseItemService->destroySingleImage($id);

        return ApiResponse::successResponse('Case Item deleted successfully');
    }
}
