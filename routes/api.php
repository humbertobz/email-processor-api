<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuccessfulEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('emails')->group(function () {
        Route::post('/', [SuccessfulEmailController::class, 'store']); // Criar novo registro
        Route::get('/{id}', [SuccessfulEmailController::class, 'show']); // Buscar por ID
        Route::put('/{id}', [SuccessfulEmailController::class, 'update']); // Atualizar por ID
        Route::get('/', [SuccessfulEmailController::class, 'index']); // Listar todos
        Route::delete('/{id}', [SuccessfulEmailController::class, 'destroy']); // Soft delete por ID
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
