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
use App\Models\Reservation;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\RoleController;


// ====================
// Routes publiques
// ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ====================
// Routes protégées (auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {

    // Profil utilisateur connecté
    Route::get('/user/{id}', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);
    
     // Routes Matière
    Route::get('/matieres', [MatiereController::class, 'index']);
    Route::post('/matieres', [MatiereController::class, 'store']);
    Route::get('/matieres/{id}', [MatiereController::class, 'show']);
    Route::put('/matieres/{id}', [MatiereController::class, 'update']);
    Route::delete('/matieres/{id}', [MatiereController::class, 'destroy']);

    // Routes Cours
    Route::get('/cours', [CoursController::class, 'index']);
    Route::post('/cours', [CoursController::class, 'store']);
    Route::get('/cours/{id}', [CoursController::class, 'show']);
    Route::put('/cours/{id}', [CoursController::class, 'update']);
    Route::delete('/cours/{id}', [CoursController::class, 'destroy']);

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

        // Gestion des équipements (CRUD complet)
        Route::apiResource('equipements', EquipementController::class);

        // Gestion des réservations (CRUD complet)
        Route::apiResource('reservations', ReservationController::class);

        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::post('/salles/store', [SalleController::class, 'store']);
        Route::post('/salles/update/{id}', [SalleController::class, 'update']);
        Route::delete('salles/delete/{id}' , [SalleController::class , 'destroy']);
        Route::get('/equipements', [EquipementController::class, 'index']);
        Route::put('/reservations/{id}/valider', [ReservationController::class, 'valider']);
        Route::put('/reservations/{id}/rejeter', [ReservationController::class, 'rejeter']);


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

    // Routes Admin uniquement
    Route::middleware('role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });

    // Routes User uniquement
    Route::middleware('role:User')->group(function () {
        Route::get('/reservations', [ReservationController::class, 'index']);
        Route::post('/reservations', [ReservationController::class, 'store']);
        Route::get('/reservations/{id}', [ReservationController::class, 'show']);
        Route::put('/reservations/{id}', [ReservationController::class, 'update']);
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
        Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
    });

    // ====================
    // Routes pour Matières & Cours (accessibles aux utilisateurs connectés)
    // ====================
    Route::get('/matieres', MatiereController::class , 'index');
    Route::post('/matieres', MatiereController::class , 'store');
    Route::delete('/matieres/{id}', MatiereController::class , 'destroy');
    Route::put('/matieres/update', MatiereController::class , 'update');

    Route::apiResource('cours', CoursController::class);

    // Routes partagées
    Route::get('/reservations', [ReservationController::class, 'index']);

});
