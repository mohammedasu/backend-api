<?php

namespace App\Http\Controllers;

use App\Models\LiveEvent;
use App\Helpers\ApiResponse;
use App\Http\Requests\LiveEvent\LiveEventRequest;
use App\Http\Requests\LiveEvent\LiveEventUpdateRequest;
use App\Http\Resources\LiveEvent\LiveEventCollection;
use App\Http\Resources\LiveEvent\LiveEventResource;
use App\Services\LiveEventService;
use App\Services\QuizService;
use Illuminate\Http\Request;

class LiveEventController extends Controller
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->live_event_service = new LiveEventService();
        $this->quiz_service = new QuizService();
    }

    /**
     * Get All Live Event
     */

    public function index(Request $request)
    {
        $live_event = $this->live_event_service->getAll($request);

        return ApiResponse::successResponse('Get Live Event Successfully', new LiveEventCollection($live_event));
    }

    /**
     * Store Live Event
     */
    public function store(LiveEventRequest $request)
    {
        $live_event = $this->live_event_service->store($request);

        return ApiResponse::successResponse('Add Live Event Successfully', new LiveEventResource($live_event));
    }

    /**
     * Update Live Event
     */
    public function update(LiveEventUpdateRequest $request, LiveEvent $live_event)
    {
        $request['id'] = $live_event->id;
        $live_event = $this->live_event_service->update($request);

        return ApiResponse::successResponse('Update Live Event Successfully', new LiveEventResource($live_event));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request, $id)
    {
        if($request->has('link_id')) {
            $request->link_id = $id;
            $live_event = $this->live_event_service->fetch($request);
            return ApiResponse::successResponse('LiveEvent Details has been fetched successfully.', new LiveEventResource($live_event));
        }

        $live_event = $this->live_event_service->show($id);
        return ApiResponse::successResponse('LiveEvent Details has been fetched successfully.', new LiveEventResource($live_event));
    }

    /**
     * Update Live Event Status
     */
    public function updateStatus(Request $request)
    {
        $live_event = $this->live_event_service->updateStatus($request);

        return ApiResponse::successResponse('LiveEvent Status Change successfully.', new LiveEventResource($live_event));
    }

    /**
     * Delete LiveEvent
     */
    public function destroy(Request $request, $id)
    {
        $request['id'] = $id;
        $this->live_event_service->destroy($request);
        return ApiResponse::successResponse('LiveEvent Deleted successfully.');
    }

    /**
     * Generate Certificate
     */
    public function generateCertificate(Request $request, $id)
    {
        $request['id'] = $id;
        $data = $this->live_event_service->generateCertificate($request);
        return ApiResponse::successResponse('Generate Certificate successfully.', new LiveEventResource($data));
    }

    /**
     * Download Live Event
     */
    public function liveEventDownload(Request $request, $id)
    {
        $request['id'] = $id;
        $data = $this->live_event_service->liveEventDownload($request);
        return ApiResponse::successResponse('LiveEvent Download successfully.', $data);
    }

    /**
     * Send Email
     */
    public function sendMail(Request $request, $id)
    {
        $request['id'] = $id;
        $data = $this->live_event_service->sendMail($request);
        return ApiResponse::successResponse('LiveEvent Mail Send successfully.', $data);
    }

    /**
     * Get Quiz
     */
    public function getQuiz(Request $request)
    {
        $data = $this->quiz_service->getAll($request);
        return ApiResponse::successResponse('Get Quiz successfully.', $data);
    }
}
