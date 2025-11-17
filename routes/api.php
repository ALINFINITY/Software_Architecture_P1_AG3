<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;

// Rutas de la API

// register y login son rutas publicas

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// logout y las rutas del CRUD de usuarios requieren token

// Grupo protegido con Sanctum
Route::middleware('auth:sanctum')->group(function () {
    //logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Rutas CRUD de usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
});