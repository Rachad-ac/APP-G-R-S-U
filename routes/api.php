<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ReservationController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Routes accessibles à tous les utilisateurs connectés
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/user/all', [UserController::class , 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route réservée uniquement aux admins
    Route::middleware('role:Admin')->group(function () {

        Route::get('/test', function () {
            return response()->json(['message' => 'hello']);
        });

        // routes admin ici
        Route::delete('user/delete/{id}' , [UserController::class , 'destroy']);
    });

    // Route réservée uniquement aux utilisateurs
    Route::middleware('role:User')->group(function () {

            // routes user ici
            Route::apiResource('salles', SalleController::class);
            Route::apiResource('reservations', ReservationController::class);
        });

    //Les autres routes partager ici
});
