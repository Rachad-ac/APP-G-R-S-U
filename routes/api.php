<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\CoursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());
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
});
