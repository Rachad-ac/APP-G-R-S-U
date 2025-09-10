<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Routes non proteger pour admin ou user
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () { 

    //Routes proteger pour admin ou user
    Route::get('/user', fn (Request $request) => $request->user()); 
    Route::get('/user/all', [UserController::class , 'index']);
    Route::delete('user/delete/{id}' , [UserController::class , 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']); 

    //Les autres routes ici
}); 