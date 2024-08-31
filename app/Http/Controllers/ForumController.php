<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Resources\Forum\ForumCollection;
use App\Http\Resources\Forum\ForumResource;
use App\Services\ForumService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Forum\ForumRequest;
use App\Http\Requests\Forum\ForumUpdateRequest;

class ForumController extends Controller
{

    private $forum_service;


    public function __construct()
    {
        //$this->middleware('permission:forum', ['only' => ['index']]);
        $this->middleware('permission:add-forum', ['only' => ['store']]);
        $this->middleware('permission:edit-forum', ['only' => ['show','update']]);
        $this->middleware('permission:delete-forum|restore-forum', ['only' => ['destroy','restore']]);
        $this->middleware('permission:update-forum-status', ['only' => ['updateStatus']]);

        $this->forum_service = new ForumService();
    }

    public function index(Request $request): JsonResponse
    {
        $data = $this->forum_service->getAll($request);
        return ApiResponse::successResponse('Data has been fetched successfully.', new ForumCollection($data));
    }


    public function store(ForumRequest $request)
    {
        $ip_address = $request->ip();
        $request['ip_address'] = $ip_address;
        $data = $this->forum_service->store($request->all());
        return ApiResponse::successResponse('Data has been added successfully.', new ForumResource($data));
    }

    public function update(ForumUpdateRequest $request, $id)
    {
        $request['forum_id'] = $id;
        $request['ip_address'] = $request->ip();
        $data = $this->forum_service->update($request->all());
        return ApiResponse::successResponse('Data has been updated successfully.', new ForumResource($data));
    }

    public function destroy(Request $request, $id)
    {
        $request['id'] = $id;
        $data = $this->forum_service->destroy($request->all());
        return ApiResponse::successResponse('Data has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request['id'] = $id;
        $data = $this->forum_service->updateStatus($request->all());
        return ApiResponse::successResponse('Data has been updated successfully.', new ForumResource($data));
    }
    public function show(Request $request, $id)
    {
        $request['id']=$id;
        $data = $this->forum_service->show($request->all());
        return ApiResponse::successResponse('Details has been fetched successfully.', new ForumResource($data));
    }
    public function restore(Request $request, $id): JsonResponse
    {
        $request['id'] = $id;
        $data = $this->forum_service->restore($request->all());
        return ApiResponse::successResponse('Data has been restore successfully.');
    }
}
