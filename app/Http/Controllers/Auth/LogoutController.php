<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $result = $request->user()->currentAccessToken()->delete();
        $success = $result == 1;
        $headers = ['Content-Type' => 'application/json; charset=utf-8'];
        return response()->json($success, 200, $headers, JSON_UNESCAPED_UNICODE);
    }
}
