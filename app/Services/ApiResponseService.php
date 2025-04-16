<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * ApiResponseService provides standardized JSON responses for API endpoints.
 * This service helps maintain consistent response structures across the application.
 */
class ApiResponseService
{
    /**
     * Returns a successful JSON response with the provided data.
     *
     * @param array|AnonymousResourceCollection|JsonResource $data The data to be returned in the response
     * @param int $code The HTTP status code (default: 200)
     * @return \Illuminate\Http\JsonResponse
     *
     * @example
     * ApiResponseService::success(['key' => 'value']);
     * // Returns: {"ok": true, "data": {"key": "value"}}
     */
    public static function success(array|AnonymousResourceCollection|JsonResource $data, $code = 200)
    {
        return response()->json([
            'ok' => true,
            'data' => $data
        ], $code);
    }

    /**
     * Returns an error JSON response with the provided message and optional error details.
     *
     * @param string $message The error message to be returned
     * @param int $code The HTTP status code (default: 400)
     * @param array $errors Optional array of error details
     * @return \Illuminate\Http\JsonResponse
     *
     * @example
     * ApiResponseService::error('Validation failed', 422, ['field' => 'Invalid value']);
     * // Returns: {"ok": false, "message": "Validation failed", "errors": {"field": "Invalid value"}}
     */
    public static function error(string $message, $code = 400, array $errors = [])
    {
        return response()->json([
            'ok' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}