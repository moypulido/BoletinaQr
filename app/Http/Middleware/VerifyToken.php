<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use App\Http\Responses\ApiResponse;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return ApiResponse::error('Token not provided', 401);
        }

        if ($token !== Token::find(1)->token) {
            return ApiResponse::error('Invalid token', 401);
        } 

        return $next($request);
    }
}