<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Services\UserService;

class AuthController extends Controller
{

    public function signup(UserService $userService, StoreUserRequest $request)
    {
        return $userService->signup($request);
    }

    public function login(UserService $userService, LoginUserRequest $request)
    {
        return $userService->login($request);
    }

    public function logout(UserService $userService)
    {
        return $userService->logout();
    }

    public function unauthorized(UserService $userService)
    {
        return $userService->unauthorized();
    }
}
