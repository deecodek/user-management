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

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(GetUserRequest $request)
    {
        $userId = (int) $request->user;
        
        $user = $this->userService->getUserById($userId);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserRequest $request)
    {
        $this->userService->deleteUser((int)$request->user);

        return response()->noContent();
    }
}
