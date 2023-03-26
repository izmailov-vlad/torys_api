<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Cassandra\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $token = '';
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $user = null;

        }
        if ($user != null) {
            $token = $user->createToken(request('email'))->plainTextToken;
        }
        $remember = true;
        $attemptResult = Auth::attempt(['email' => $user->email, 'password' => $user->password], $remember);

        if ($attemptResult) Log::info('attempt success');


        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['user' => $user, 'token' => $token], 200, $headers, JSON_UNESCAPED_UNICODE);
    }


    public function checkUser()
    {
        $result = false;
        $user = null;

        if (Auth::check()) {
            $result = true;
            $user = Auth::user();
        }

        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json(['user' => $user, 'auth' => $result], 200, $headers, JSON_UNESCAPED_UNICODE);
    }

    public function user(Request $request)
    {
        return $request->user();
    }
}
