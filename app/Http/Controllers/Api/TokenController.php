<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Http\Responses;

class TokenController extends Controller
{
    public function update_token()
    {
        $token = Token::find(1);
        $token->update([
            'token' => 'App-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-'), 0, rand(20, 30)).'-Token-BoletosQR',
            'updated_at' => now(),
        ]);

        return Responses\ApiResponse::success('Token updated successfully', $token);
    }

    public function get_token()
    {
        $token = Token::find(1);
        return Responses\ApiResponse::success('Token retrieved successfully', $token);
    }
}