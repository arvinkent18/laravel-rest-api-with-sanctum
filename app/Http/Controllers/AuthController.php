<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->get('email'))->first();

        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return response([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('token-sample')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function logout() {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }
}
