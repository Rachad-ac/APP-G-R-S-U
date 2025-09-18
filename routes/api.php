<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ==========================
// Routes publiques
// ==========================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ==========================
// Routes protégées (authentification requise)
// ==========================
Route::middleware('auth:sanctum')->group(function () {

    // Profil utilisateur connecté
    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // ==========================
    // Routes Admin uniquement
    // ==========================
    Route::middleware('role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Gestion des équipements (CRUD)
        Route::apiResource('equipements', EquipementController::class);

        // Gestion des réservations (CRUD)
        Route::apiResource('reservations', ReservationController::class);
    });

    // ==========================
    // Routes User uniquement
    // ==========================
    Route::middleware('role:User')->group(function () {
        // Un utilisateur peut créer une réservation
        Route::post('/reservations', [ReservationController::class, 'store']);

        // Voir ses propres réservations
        Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
    });


    // Routes partagées

    Route::get('/equipements', [EquipementController::class, 'index']);
    Route::get('/reservations', [ReservationController::class, 'index']);
});
