<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\FiliereController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées (authentification requise)
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', fn (Request $request) => $request->user());
    Route::post('/logout', [AuthController::class, 'logout']);


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
       Route::get('/filieres', [FiliereController::class, 'index']);
Route::post('/filieres', [FiliereController::class, 'store']);
Route::get('/filieres/{id}', [FiliereController::class, 'show']);
Route::put('/filieres/{id}', [FiliereController::class, 'update']);
Route::delete('/filieres/{id}', [FiliereController::class, 'destroy']);
    });
});
