<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register User routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
|
| Prefix => api/v1/user
|
|
*/

Route::post('/login', [UserController::class, 'login']); #login

Route::group(
    [
        'middleware' => ['jwt:user']
    ],

    function () {


        //******************************** Auth  ********************************//
        Route::controller(UserController::class)->group(function () {

            Route::post('/logout', 'logout'); #logout
            Route::get('/profile', 'profile'); # get account data

        });



    });

