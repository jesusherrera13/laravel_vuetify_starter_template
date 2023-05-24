<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SystemModuloController;

Route::post('/v1/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    // SYSTEM MODULOS
    Route::get('/v1/system-modulo', [SystemModuloController::class, 'index']);
    Route::post('/v1/system-modulo', [SystemModuloController::class, 'store']);
    Route::post('/v1/system-modulo/{systemModulo}', [SystemModuloController::class, 'update']);
    Route::post('/v1/system-modulos', [SystemController::class, 'systemModulos']);
    // SYSTEM MODULOS

    Route::post('/v1/logout', [AuthController::class, 'logout']);
});
