<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Traits\GeneralTrait;

class AdminController extends Controller
{
    use GeneralTrait;
    public function login(AdminLoginRequest $request)
    {

        $credentials = $request->only(['email','password']);

        if (! $token = auth('admin')->attempt($credentials)) {
            return $this->responseMessage(401,false,'البريد الإلكترونى اول كلمة المرور غير صحيح');
        }

        $admin = auth('admin')->user();
        $admin->access_token = $token;
        $admin->token_type = 'bearer';
        $admin->expires_in = auth('admin')->factory()->getTTL() * 60; //mention the guard name inside the auth fn
        return $this->responseMessage(200,true,null,$admin);

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
