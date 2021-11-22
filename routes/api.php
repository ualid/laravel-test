<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NumberController;
use App\Http\Controllers\NumberPreferenceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatusController;


Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::resource('/statuses', StatusController::class)
        ->only('index');
    Route::resource('/users', UserController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/numbers', NumberController::class);
    Route::resource('/number-preferences', NumberPreferenceController::class);
});
