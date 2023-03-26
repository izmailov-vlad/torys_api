<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request) {

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['user' => $user, 'token' => $user->createToken(request('email'))->plainTextToken], 200, $headers, JSON_UNESCAPED_UNICODE);

    }
}
