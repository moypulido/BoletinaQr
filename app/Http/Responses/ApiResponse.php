<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class ApiResponse
{
    public static function success($message, $data = null, $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error($message, $status = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
        ], $status);
    }

    public static function paginate($message, $paginator, $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'limit' => $paginator->perPage(),
                'page' => $paginator->currentPage(),
            ],
        ], $status);
    }
    
}
