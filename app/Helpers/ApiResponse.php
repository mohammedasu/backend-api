<?php

namespace App\Helpers;

use App\Constants\Constants;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Defined success response format
     * @param $message
     * @param $response
     * @return JsonResponse
     */
    public static function successResponse($message, $response = null): JsonResponse
    {
        return response()->json([
        'status' => true,
        'message' => $message,
        'response' => $response
        ],Constants::SUCCESS_RESPONSE_CODE);
    }

    /**
     * Defined failure response format
     * @param $message
     * @param $response
     * @param int $code
     * @return JsonResponse
     */
    public static function failureResponse($message, $response = null, int $code = Constants::ACCESS_FORBIDDEN_RESPONSE_CODE): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'response' => $response
        ], $code);
    }

    /**
     * Defined validation response
     * @param $message
     * @param $response
     * @return JsonResponse
     */
    public static function validationFailure($message, $response): JsonResponse
    {
        return response()->json([
        'status' => false,
        'message' => $message,
        'response' => $response
        ], Constants::VALIDATION_RESPONSE_CODE);
    }

    public static function customArrayResponse($status, $code, $message, $response): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'response' => $response
        ];
    }
}
