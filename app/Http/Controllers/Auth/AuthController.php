<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'user',
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Registered',
            'data' => [
                'access_token' => $token,
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user' => $user,
            ],
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
                'errors' => [],
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login success',
            'data' => [
                'access_token' => $token,
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user' => JWTAuth::user(),
            ],
        ]);
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            return response()->json([
                'success' => true,
                'message' => 'This is your profile right now',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'data' => null,
            ], 401);
        }
    }


    public function refresh()
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Token refreshed successfully',
            'data' => [
                'access_token' => $token,
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ],
        ]);
    }

    public function logout()
    {
        try {
            if ($token = JWTAuth::getToken()) {
                JWTAuth::invalidate($token);
            }
        } catch (\Exception $e) {
            // token invalid / expired → ignore
        }

        return response()->json([
            'success' => true,
            'message' => 'Logged out',
            'data' => null,
        ]);
    }

}
