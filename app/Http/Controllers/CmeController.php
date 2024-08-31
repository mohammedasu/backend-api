<?php

namespace App\Http\Controllers;

use App\Models\Cme;
use App\Services\CmeService;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Cme\CmeResource;
use App\Http\Resources\Cme\CmeCollection;
use App\Http\Requests\Cme\CmeStoreRequest;
use App\Http\Requests\Cme\CmeUpdateRequest;

class CmeController extends Controller
{
    private $cmeService;

    /**
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('permission:cme', ['only' => ['index']]);
        $this->middleware('permission:add-cme', ['only' => ['store']]);
        $this->middleware('permission:edit-cme', ['only' => ['show', 'update']]);
        $this->middleware('permission:delete-cme', ['only' => ['destroy']]);
        $this->middleware('permission:update-cme-status', ['only' => ['toggleStatus']]);
        $this->cmeService = new CmeService();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        $cmeList = $this->cmeService->getAll($request);
        return ApiResponse::successResponse('CME List has been fetched successfully.', new CmeCollection($cmeList));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CmeStoreRequest $request
     * @return JsonResponse
     */
    public function store(CmeStoreRequest $request): JsonResponse
    {
        $cme = $this->cmeService->store($request);
        return ApiResponse::successResponse('CME has been added successfully.', new CmeResource($cme));
    }

    /**
     * Display the specified resource.
     *
     * @param Cme $cme
     * @return JsonResponse
     */
    public function show(Cme $cme): JsonResponse
    {
        return ApiResponse::successResponse('CME Details has been fetched successfully.', new CmeResource($cme));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CmeUpdateRequest $request
     * @param Cme $cme
     * @return JsonResponse
     */
    public function update(CmeUpdateRequest $request, Cme $cme): JsonResponse
    {
        $cme = $this->cmeService->update($request, $cme);
        return ApiResponse::successResponse('CME has been updated successfully.', new CmeResource($cme));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cme $cme
     * @return JsonResponse
     */
    public function destroy(Cme $cme): JsonResponse
    {
        $response = $this->cmeService->destroy($cme);
        return ApiResponse::successResponse('CME has been deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $this->cmeService->updateStatus($request);
        return ApiResponse::successResponse('CME Status Updated Successfully');
    }
}
