<?php

use App\Http\Controllers\Api\AuthController as AuthControllerAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::controller(AuthControllerAlias::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});


