<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\CollaborationController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
// Routes pour l'authentification
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// Routes protégées par middleware 'auth:sanctum' pour les rôles
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('projets', ProjetController::class);
    Route::apiResource('collaborations', CollaborationController::class);
    Route::apiResource('taches', TacheController::class);
    Route::apiResource('contenus', ContenuController::class);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::apiResource('profiles', ProfileController::class);

});

// Route pour obtenir les informations de l'utilisateur authentifié
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
