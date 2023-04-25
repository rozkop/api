<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\BaseResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, AuthService $service)
    {
        $response = $service->registerUser(
            $request->email,
            $request->name,
            $request->password
        );

        return $response;
    }

    public function login(LoginUserRequest $request, AuthService $service)
    {
        $response = $service->loginUser(
            $request->email,
            $request->password
        );

        return $response;
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();

        return BaseResource::make(['message' => 'Logged out!']);
    }
}