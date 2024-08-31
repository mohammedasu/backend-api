<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\NotificationService;
use App\Http\Requests\Notification\NotificationStoreRequest;
use App\Http\Requests\Notification\NotificationUpdateRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Notification\NotificationCollection;

class NotificationController extends Controller
{
    private $notificationService;

    /**
     * @return void
     */
    public function __construct(){
        
        $this->middleware('permission:communication', ['only' => ['index']]);
        $this->middleware('permission:add-communication', ['only' => ['store']]);
        $this->middleware('permission:edit-communication', ['only' => ['show', 'update']]);
        $this->middleware('permission:delete-communication', ['only' => ['destroy']]);

       $this->notificationService = new NotificationService();
    }

    /**
     * Display a listing of the resource.
     *
    */

    public function index(Request $request)
    {
        $notificationList = $this->notificationService->getAll($request);
        return ApiResponse::successResponse('Notification List has been fetched successfully.', new NotificationCollection($notificationList));
    }

    public function checkContent(NotificationStoreRequest $request)
    {
        $data = $this->notificationService->checkContent($request);
        return ApiResponse::successResponse('Data has been ready to send notification .', $data);
    }

    public function store(NotificationStoreRequest $request)
    {
        $notification = $this->notificationService->store($request);
        return ApiResponse::successResponse('Notification has been sent successfully.', $notification);
    }

    /**
     * Display the specified resource.
     *
    */
    public function show(Notification $notification)
    {
        return ApiResponse::successResponse('Notification Details has been fetched successfully.', new NotificationResource($notification));
    }

    /**
     * Update the specified resource in storage.
     *
    */
    public function update(NotificationUpdateRequest $request, Notification $notification)
    {
        $notification = $this->notificationService->update($request, $notification);
        return ApiResponse::successResponse('Notification has been updated successfully.',new NotificationResource($notification));
    }

    /**
     * Remove the specified resource from storage.
     *
    */
    public function destroy(Notification $notification)
    {
        $this->notificationService->destroy($notification);
        return ApiResponse::successResponse('Notification has been deleted successfully.');
    }
}
