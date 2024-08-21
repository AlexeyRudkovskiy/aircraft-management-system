<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json()->setStatusCode(Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
        ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
    }

    public function me()
    {
        return auth()->user();
    }

}
