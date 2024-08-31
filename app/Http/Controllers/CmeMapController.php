<?php

namespace App\Http\Controllers;

use App\Models\CmeMap;
use App\Helpers\ApiResponse;
use App\Services\CmeMapService;
use Illuminate\Http\JsonResponse;

class CmeMapController extends Controller
{
    private $cmeMapService;

    /**
     * @return void
     */
    public function __construct(){
       $this->cmeMapService = new CmeMapService();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CmeMap $cmeMap
     * @return JsonResponse
     */
    public function destroy(CmeMap $cmeMap): JsonResponse
    {
        $response = $this->cmeMapService->destroy($cmeMap);
        return ApiResponse::successResponse('CME attachment has been deleted successfully.');
    }
}
