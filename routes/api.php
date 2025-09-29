<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\Api\MatiereController;
use App\Http\Controllers\Api\CoursController;
use App\Http\Controllers\RoleController;

// ====================
// Routes publiques
// ====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ====================
// Routes protégées (auth:sanctum)
// ====================
Route::middleware('auth:sanctum')->group(function () {

    // Profil utilisateur connecté
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // ====================
    // Routes Admin uniquement
    // ====================
    Route::middleware('role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Gestion des équipements (CRUD complet)
        Route::apiResource('equipements', EquipementController::class);

        // Gestion des réservations (CRUD complet)
        Route::apiResource('reservations', ReservationController::class);

        // Gestion des rôles (test/optionnel)
        Route::apiResource('roles', RoleController::class)->only(['index','store','destroy']);
    });

    // ====================
    // Routes pour Matières & Cours (accessibles aux utilisateurs connectés)
    // ====================
    Route::apiResource('matieres', MatiereController::class);
    Route::apiResource('cours', CoursController::class);
});
