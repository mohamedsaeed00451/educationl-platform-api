<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
|
| Prefix => api/v1/admin
|
|
*/


Route::post('/login', [AdminController::class, 'login']); #login

Route::group(
    [
        'middleware' => ['jwt:admin']
    ],

    function () {


        //******************************** Auth  ********************************//
        Route::controller(AdminController::class)->group(function () {

            Route::post('/logout', 'logout'); #logout
            Route::get('/profile', 'profile'); # get account data

        });


    });
