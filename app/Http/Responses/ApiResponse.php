<?php

namespace App\Http;

use Illuminate\Support\Js;

class ApiResponse
{
    
    /**
     * success response method.
     *
     * @param mixed $data
     * @param string $message
     * @param int $code = 200
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data, string $message = "Success", int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * created response method.
     * 
     * @param mixed $data
     * @param string $message
     * @param int $code = 201
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created($data, string $message = "Created", int $code = 201)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    
    /** 
     * badRequest response method.
     * @param mixed $name
     * @param string $message
     * @param int $code = 400
     * @return \Illuminate\Http\JsonResponse
     */
    public static function badRequest($data, string $message = "Bad Request", int $code = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * unauthorized response method.
     * 
     * @param mixed $data
     * @param string $message
     * @param int $code = 401
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized($data, string $message = "Unauthorized", int $code = 401)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}   
