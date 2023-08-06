<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Traits\GeneralTrait;

class UserController extends Controller
{

    use GeneralTrait;
    public function login(UserLoginRequest $request)
    {

        $credentials = $request->only(['username','password']);

        if (! $token = auth('user')->attempt($credentials)) {
            return $this->responseMessage(401,false,'Unauthorized');
        }

        $user = auth('user')->user();
        $user->access_token = $token;
        $user->token_type = 'bearer';
        $user->expires_in = auth('user')->factory()->getTTL() * 60; //mention the guard name inside the auth fn
        return $this->responseMessage(200,true,null,$user);

    }

    public function profile()
    {
        return $this->responseMessage(200,true,null,auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return $this->responseMessage(200,true,'Successfully logged out');
    }
}
