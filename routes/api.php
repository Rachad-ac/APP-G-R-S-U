<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Routes non proteger pour user
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () { 

    //Routes proteger pour user
    Route::get('/user', fn (Request $request) => $request->user()); 
    Route::get('/user/all', [UserController::class , 'index']);
    Route::delete('user/delete/{id}' , [UserController::class , 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']); 

    // Routes pour projets
    Route::get('/projects', [ProjetController::class, 'index']);
    Route::get('/projects/{id}', [ProjetController::class, 'show']);
    Route::post('/projects', [ProjetController::class, 'store']);
    Route::put('/projects/{id}', [ProjetController::class, 'update']);
    Route::delete('/projects/{id}', [ProjetController::class, 'destroy']);
        
    // Routes pour tâches
    Route::get('/taches', [TacheController::class, 'index']);
    Route::get('/taches/{id}', [TacheController::class, 'show']);
    Route::post('/taches', [TacheController::class, 'store']);
    Route::put('/taches/{id}', [TacheController::class, 'update']);
    Route::delete('/taches/{id}', [TacheController::class, 'destroy']); 

    // Route pour commentaires
    Route::get('/comments', [CommentController::class, 'index']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

}); 