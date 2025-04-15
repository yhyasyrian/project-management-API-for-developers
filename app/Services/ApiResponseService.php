<?php

namespace App\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiResponseService
{
    public static function success(array|AnonymousResourceCollection|JsonResource $data, $code = 200)
    {
        return response()->json([
            'ok' => true,
            'data' => $data
        ], $code);
    }

    public static function error(string $message, $code = 400, array $errors = [])
    {
        return response()->json([
            'ok' => false,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

}