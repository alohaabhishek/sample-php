<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

// Public
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/refresh', [AuthController::class,'refresh']);

// Protected
Route::middleware(['custom.jwt'])->group(function () {

    Route::post('/logout', [AuthController::class,'logout']);

    Route::get('/tasks', [TaskController::class,'index']);
    Route::post('/tasks', [TaskController::class,'store']);
    Route::put('/tasks/{id}', [TaskController::class,'update']);
    Route::delete('/tasks/{id}', [TaskController::class,'delete']);
    Route::put('/tasks/completed/{id}', [TaskController::class,'markAsCompleted']);
});