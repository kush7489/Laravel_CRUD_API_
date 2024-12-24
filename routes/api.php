<?php

use App\Http\Controllers\API\Authcontroller;
use App\Http\Controllers\Authenticate_user;
use App\Http\Controllers\DetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// user register  and login
Route::post('/register',[Authcontroller::class,'register']);
Route::post('/login',[Authcontroller::class,'login']);

// Protected Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {    
    Route::get('dashboard', [Authenticate_user::class, 'dashboard']);
    // Route::get('user')
     
});
// testing purpose
// Route::resource('user',DetailController::class);