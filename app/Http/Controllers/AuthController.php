<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name'      => 'required|string|min:3|max:255',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => 'required|min:6|max:255|confirmed',
        ]);

        User::create($attributes);

        return $this->login($request);
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email'     => 'email|required',
            'password'  => 'string|required',
        ]);

        if (!Auth::attempt($attributes)) {

            return response()->json([
                'message' => 'Email or Password is not valid.'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();


        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => "Signed in successfully",
            'access_token' => $token,
            'user' => $user,
        ]);
    }
    public function logout()
    {
        $user = Auth::user();

        $user->currentAccesstoken()->delete();

        return response([
            'message' => "Logout successfully",
            'success' => true
        ]);
    }
}
