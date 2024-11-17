<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($message, $data = null, $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    public static function error($message, $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => $message,
        ], $status);
    }
}
