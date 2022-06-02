<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthentication'
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = explode('|', $user->createToken('authentication-token')->plainTextToken)[1];

        return response()->json([
            'status' => 200,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user()->tokens()->delete();

        return response()->json([
            'status' => 200,
            'token' => $user,
        ]);
    }
}
