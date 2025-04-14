<?php

namespace App\Services;

class ApiResponseService
{
    public static function success(array $data, $code = 200)
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