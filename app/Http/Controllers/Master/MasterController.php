<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Services\MasterService;
use Illuminate\Http\JsonResponse;

class MasterController extends Controller
{

    private $master_service;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->master_service = new MasterService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchForumTypes(Request $request): JsonResponse
    {
        $data = $this->master_service->fetchForumTypes($request);
        return ApiResponse::successResponse('Forum types has been fetched successfully.', $data);
    }
    public function fetchUserTypes(Request $request): JsonResponse
    {
        $data = $this->master_service->fetchUserTypes($request);
        return ApiResponse::successResponse('User types has been fetched successfully.', $data);
    }
    public function countryList(Request $request): JsonResponse
    {
        $data = $this->master_service->countryList($request);
        return ApiResponse::successResponse('Country list fetched successfully.', $data);
    }
    public function getDataFilterMemberTypes(Request $request): JsonResponse
    {
        $data = $this->master_service->getDataFilterMemberTypes($request);
        return ApiResponse::successResponse('Member type fetched successfully.', $data);
    }
    public function getDigiMrStatus(Request $request): JsonResponse
    {
        $data = $this->master_service->getDigiMrStatus($request);
        return ApiResponse::successResponse('Digi mr status fetched successfully.', $data);
    }

    public function fetchAttachmentTypes()
    {
        $data = $this->master_service->fetchAttachmentTypes();
        return ApiResponse::successResponse('Attachment types has been fetched successfully.', $data);
    }

    public function fetchQuestionBankTypes()
    {
        $data = $this->master_service->fetchQuestionBankTypes();
        return ApiResponse::successResponse('Question types has been fetched successfully.', $data);
    }

    public function fetchAttachments(Request $request)
    {
        $response = $this->master_service->fetchAttachments($request);
        return ApiResponse::successResponse('Attachments has been fetched successfully.', $response);
    }
    public function getCountryState(Request $request, $country)
    {
        $request['country'] = $country;
        $response = $this->master_service->getCountryState($request);
        return ApiResponse::successResponse('State list fetch successfully.', $response);
    }

    public function getStateBasedOnMultipleCountry(Request $request, $countries)
    {
        $request['countries'] = $countries;
        $response = $this->master_service->getStateBasedOnMultipleCountry($request);
        return ApiResponse::successResponse('State list fetch successfully.', $response);
    }

    public function fetchAllStates(Request $request)
    {
        $response = $this->master_service->fetchAllStates($request);
        return ApiResponse::successResponse('State list fetch successfully.', $response);
    }

    public function fetchAllCities(Request $request)
    {
        $response = $this->master_service->fetchAllCities($request);
        return ApiResponse::successResponse('City list fetch successfully.', $response);
    }

    public function getCityState(Request $request, $country, $state)
    {
        $request['country'] = $country;
        $request['state'] = $state;
        $response = $this->master_service->getCityState($request);
        return ApiResponse::successResponse('City list fetch successfully.', $response);
    }

    public function getCityBasedOnMultipleState(Request $request, $states)
    {
        $request['states'] = $states;
        $response = $this->master_service->getCityBasedOnMultipleState($request);
        return ApiResponse::successResponse('City list fetch successfully.', $response);
    }
}
