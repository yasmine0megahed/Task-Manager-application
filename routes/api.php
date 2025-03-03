<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// login
Route::post('/login', [AuthController::class, 'login']);
// task
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']); 
    Route::post('store/task', [TaskController::class, 'store']); 
    Route::put('/task/{{id}}/update', [TaskController::class, 'update']); 
    Route::delete('/task/{id}/delete', [TaskController::class, 'destroy']); 
});