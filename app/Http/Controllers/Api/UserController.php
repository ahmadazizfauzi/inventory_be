<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Retrieve list of all users
    public function index(): JsonResponse
    {
        $users = User::latest()->paginate(15);
        $users->through(fn ($user) => new UserResource($user));

        return ApiResponse::paginated($users, 'Users retrieved successfully');
    }

    // Create a new user with specific role
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return ApiResponse::created(new UserResource($user), 'User created successfully');
    }

    // Retrieve single user detail
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        return ApiResponse::success(new UserResource($user), 'User retrieved successfully');
    }

    // Update user profile or role
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return ApiResponse::success(new UserResource($user), 'User updated successfully');
    }

    // Delete user (prevent deleting own account)
    public function destroy(int $id): JsonResponse
    {
        if ((int) auth('api')->id() === (int) $id) {
            return ApiResponse::badRequest('You cannot delete your own account.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return ApiResponse::success(null, 'User deleted successfully');
    }
}
