<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;


Route::get('/', function () {
    if (session('user_id')) {
        return redirect('/tasks');
    }
    return view('auth');
});

// // Auth routes
Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);
Route::post('/logout', [AuthController::class,'logout']);

// Protected routes
Route::middleware(['auth.custom'])->group(function () {

    Route::get('/tasks', [TaskController::class,'index']);
    Route::post('/tasks', [TaskController::class,'store']);
    Route::post('/tasks/update/{id}', [TaskController::class,'update']);
    Route::post('/tasks/delete/{id}', [TaskController::class,'delete']);
    Route::put('/update-name/{user_id}', [AuthController::class,'update_name']);
});