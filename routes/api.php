<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Routes accessibles à tous les utilisateurs connectés
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/user/all', [UserController::class , 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/salles/index', [SalleController::class, 'index']);
    Route::get('/salles/{id}', [SalleController::class, 'show']);
    Route::post('/reservations/index', [ReservationController::class, 'index']);
    Route::delete('reservations/delete/{id}' , [ReservationController::class , 'destroy']);
    Route::get('/salles/search', [SalleController::class, 'search']);
    Route::get('/reservations/search', [ReservationController::class, 'search']);
    Route::get('/users/{id}/mesreservations', [ReservationController::class, 'mesreservations']);





    // Route réservée uniquement aux admins
    Route::middleware('role:Admin')->group(function () {

        Route::get('/test', function () {
            return response()->json(['message' => 'hello']);
        });

        // routes admin ici
        Route::delete('user/delete/{id}' , [UserController::class , 'destroy']);
        Route::post('/salles/store', [SalleController::class, 'store']);
        Route::post('/salles/update/{id}', [SalleController::class, 'update']);
        Route::delete('salles/delete/{id}' , [SalleController::class , 'destroy']);

        Route::put('/reservations/{id}/valider', [ReservationController::class, 'valider']);
        Route::put('/reservations/{id}/rejeter', [ReservationController::class, 'rejeter']);


    });

    // Route réservée uniquement aux utilisateurs
    Route::middleware('role:User')->group(function () {

            // routes user ici
        Route::post('/reservations/ajout', [ReservationController::class, 'store']);
        Route::get('/reservations/{id}', [ReservationController::class, 'show']);
        Route::post('/reservations/update/{id}', [ReservationController::class, 'update']);

        });

    //Les autres routes partager ici
});
