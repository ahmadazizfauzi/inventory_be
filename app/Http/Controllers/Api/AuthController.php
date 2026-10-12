<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Auth\AuthService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    // Handle user registration
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return ApiResponse::created([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'User registered successfully');
    }

    // Handle user login and JWT token generation
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        if (! $result) {
            return ApiResponse::unauthorized('Invalid email or password');
        }

        return ApiResponse::success([
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'Login successful');
    }

    // Retrieve currently authenticated user profile
    public function me(): JsonResponse
    {
        return ApiResponse::success(
            new UserResource(auth('api')->user()),
            'User profile retrieved successfully'
        );
    }

    // Invalidate current JWT token
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return ApiResponse::success(null, 'Successfully logged out');
    }
}
