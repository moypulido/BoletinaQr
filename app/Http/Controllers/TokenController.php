<?php

namespace App\Http\Controllers;

use App\Models\Token;

class TokenController extends Controller
{
    public function show()
    {
        $token = Token::find(1);
        return view('dashboard', ['token' => $token]);
    }

    public function update()
    {
        $token = Token::find(1);
        $token->update([
            'token' => 'App-' . substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_-'), 0, rand(20, 30)).'-Token-BoletosQR',
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard');
    }
}