<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Http\Resources\NotificationMaster\NotificationMasterCollection;
use App\Http\Resources\NotificationMaster\NotificationMasterResource;
use App\Services\NotificationMasterService;
use App\Http\Requests\NotificationMaster\NotificationMasterRequest;

class NotificationMasterController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:master-notification', ['only' => ['index']]);
        $this->middleware('permission:add-master-notification', ['only' => ['store']]);
        $this->middleware('permission:edit-master-notification', ['only' => ['show','update']]);
        $this->middleware('permission:delete-master-notification|restore-master-notification', ['only' => ['destroy','restore']]);
        $this->middleware('permission:update-master-notification-status', ['only' => ['toggleStatus']]);

        $this->notification_master_service = new NotificationMasterService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->notification_master_service->fetchAll($request);
        return ApiResponse::successResponse('Data has been fetched successfully.', new NotificationMasterCollection($data));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationMasterRequest $request)
    {
        $sms_template = $this->notification_master_service->store($request);
        return ApiResponse::successResponse('Add Notification Master successfully.', new NotificationMasterResource($sms_template));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sms_template = $this->notification_master_service->show($id);
        return ApiResponse::successResponse('Details has been fetched successfully.', new NotificationMasterResource($sms_template));
    }

    public function update(NotificationMasterRequest $request, $id)
    {
        $request['notification_master_ref_no'] = $id;
        $sms_template = $this->notification_master_service->update($request);
        
        return ApiResponse::successResponse('Update Notification Master Successfully', new NotificationMasterResource($sms_template));
    }

    public function destroy(Request $request, $id)
    {
        $request['notification_master_ref_no'] = $id;
        $sms_template = $this->notification_master_service->destroy($request);
        
        return ApiResponse::successResponse('Notification Master deleted successfully');
    }

    public function toggleStatus(Request $request)
    {
        $this->notification_master_service->updateStatus($request);
        
        return ApiResponse::successResponse('Notification Master Status Updated Successfully');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $this->notification_master_service->restore($id);
        return ApiResponse::successResponse('Notification Master restore successfully');
    }
}
