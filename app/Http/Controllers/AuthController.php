<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json(['status' => 'success', 'token' => $token], 200);
    }


    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role' => User::ROLE_USER
        ]);
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json(['status' => 'success', 'token' => $token], 200);
    }
}
