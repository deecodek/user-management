<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest\DeleteUserRequest;
use App\Http\Requests\UserRequest\GetUserRequest;
use App\Http\Requests\UserRequest\StoreUserRequest;
use App\Http\Requests\UserRequest\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Service\UserService;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();

        Log::info('User list fetched');

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        Log::info('User created', ['user_id' => $user->id]);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(GetUserRequest $request)
    {
        $userId = (int) $request->id;

        $user = $this->userService->getUserById($userId);

        Log::info('User fetched', ['user_id' => $userId]);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());

        Log::info('User updated', ['user_id' => $id]);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserRequest $request)
    {
        $userId = (int) $request->id;

        $this->userService->deleteUser($userId);

        Log::info('User deleted', ['user_id' => $userId]);

        return response()->noContent();
    }
}
