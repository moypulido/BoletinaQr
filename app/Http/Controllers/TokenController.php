<?php

namespace App\Http\Controllers;

use App\Models\Token;

class TokenController extends Controller
{
    public function update_token()
    {
        $token = Token::find(1);
        $token->update([
            'token' => 'App-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-'), 0, rand(20, 30)).'-Token-BoletosQR',
            'updated_at' => now(),
        ]);

        return $token;
    }	

    public function get_token()
    {
        $token = Token::find(1);
        return $token;
    }
}