<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('users/{id}', [UserController::class, 'getUserById']);
Route::post('users', [UserController::class, 'storeUser']);
Route::put('users/{id}', [UserController::class, 'updateUser']);
Route::delete('users/{id}', [UserController::class, 'deleteUser']);