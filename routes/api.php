<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Models\Reservation;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {

    // Profil utilisateur connecté
    Route::get('/user/{id}', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route réservée uniquement aux admins
    Route::middleware('role:Admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::delete('/user/{id}', [UserController::class, 'destroy']);

        // Gestion des équipements (CRUD)
        Route::apiResource('equipements', EquipementController::class);

        // Gestion des réservations (CRUD)
        Route::apiResource('reservations', ReservationController::class);

        Route::post('/reservations', [ReservationController::class, 'store']);
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
    // Routes Enseigant et Etudiant uniquement
    Route::middleware('role:Enseignant' || 'role:Etudiant')->group(function () {
        // Voir ses propres réservations
        Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
    });


    // Routes partagées
    Route::get('/dashboard', [DashboardController::class, 'stats']);
    Route::get('/equipements', [EquipementController::class, 'index']);
    Route::get('/reservations', [ReservationController::class, 'index']);
});
