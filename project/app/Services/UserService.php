<?php

namespace App\Services;

use App\Http\Requests\Api\LoginUserRequest;
use App\Http\Requests\Api\StoreUserRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserService
{
    public function signup(StoreUserRequest $request)
    {
        // авторизованный пользователь не имеет доступа к регистрации
        if (Request::header('Authorization')) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }
        $user = User::query()->create($request->all());
        // сразу для этого юзера делаю корзину
        Cart::query()->create(['user_id' => $user->id]);
        return response()->json([
            'user_token' => $user->createToken('token')->plainTextToken
        ], 201);
    }

    public function login(LoginUserRequest $request)
    {
        // авторизованный пользователь не имеет доступа к логину
        if (Request::header('Authorization')) {
            return response()->json([
                'message' => 'Forbidden for you'
            ], 403);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                'message' => 'Auth failed'
            ], 401);
        }
        $user = Auth::user();

        // удаляем старые токены этого юзера если таковы имеются
        $userId = $user['id'];
        DB::table('personal_access_tokens')->where('tokenable_id', $userId)->delete();

        return response()->json([
            'user_token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'logout'
        ]);
    }

    public function unauthorized()
    {
        return response()->json([
            'message' => 'Login failed'
        ], 403);
    }
}
