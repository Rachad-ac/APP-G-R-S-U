<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\NotificationController;


// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // Profil utilisateur connecté
    Route::get('/user/{id}', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/salles/index', [SalleController::class, 'index']);
    Route::get('/salles/{id}', [SalleController::class, 'show']);
    Route::post('/reservations/index', [ReservationController::class, 'index']);
    Route::delete('reservations/delete/{id}' , [ReservationController::class , 'destroy']);
    Route::get('/salles/search', [SalleController::class, 'search']);
    Route::get('/reservations/search', [ReservationController::class, 'search']);
    Route::get('/users/{id}/mesreservations', [ReservationController::class, 'mesreservations']);

    // Routes Equipement
    Route::get('/equipements', [EquipementController::class, 'index']);
    Route::post('/equipements', [EquipementController::class, 'store']);
    Route::get('/equipements/{id}', [EquipementController::class, 'show']);
    Route::put('/equipements/{id}', [EquipementController::class, 'update']);
    Route::delete('/equipements/{id}', [EquipementController::class, 'destroy']);

    // Route réservée uniquement aux admins
    Route::middleware('role:Admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'stats']);
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);
        
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::post('/salles/store', [SalleController::class, 'store']);
        Route::post('/salles/update/{id}', [SalleController::class, 'update']);
        Route::delete('salles/delete/{id}' , [SalleController::class , 'destroy']);
        Route::get('/equipements', [EquipementController::class, 'index']);
        Route::put('/reservations/{id}/valider', [ReservationController::class, 'valider']);
        Route::put('/reservations/{id}/rejeter', [ReservationController::class, 'rejeter']);

        Route::get('/filieres', [FiliereController::class, 'index']);
        Route::post('/filieres', [FiliereController::class, 'store']);
        Route::get('/filieres/{id}', [FiliereController::class, 'show']);
        Route::put('/filieres/{id}', [FiliereController::class, 'update']);
        Route::delete('/filieres/{id}', [FiliereController::class, 'destroy']);

        Route::get('/matieres', [MatiereController::class , 'index']);
        Route::post('/matieres', [MatiereController::class , 'store']);
        Route::delete('/matieres/{id}', [MatiereController::class , 'destroy']);
        Route::put('/matieres/update', [MatiereController::class , 'update']);

    });

    // Routes Enseigant et Etudiant uniquement
    Route::middleware('role:Enseignant' || 'role:Etudiant')->group(function () {
        Route::get('/reservations', [ReservationController::class, 'index']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::get('/reservations/{id}', [ReservationController::class, 'show']);
        Route::put('/reservations/{id}', [ReservationController::class, 'update']);
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
        Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
    });
   
    
    Route::get('/notifications/{userId}', [NotificationController::class, 'index']); 
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead']); 
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

});
