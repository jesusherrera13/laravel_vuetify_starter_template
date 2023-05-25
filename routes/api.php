<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\SystemModuloController;
use App\Http\Controllers\SystemModuloMenuController;
use App\Http\Controllers\SystemRolController;
use App\Http\Controllers\SystemAccesoModuloController;

Route::post('/v1/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() {

    Route::post('/v1/register', [AuthController::class, 'register']);
    Route::post('/v1/user-update/{user}', [AuthController::class, 'userUpdate']);


    // SYSTEM MODULOS
    Route::get('/v1/system-modulo', [SystemModuloController::class, 'index']);
    Route::post('/v1/system-modulo', [SystemModuloController::class, 'store']);
    Route::post('/v1/system-modulo/{systemModulo}', [SystemModuloController::class, 'update']);
    Route::get('/v1/system-modulo/{systemModulo}', [SystemModuloController::class, 'show']);
    Route::post('/v1/system-modulos', [SystemController::class, 'systemModulos']);
    // SYSTEM MODULOS

    // SYSTEM MENUS
    // Route::get('/v1/system-modulo', [SystemModuloController::class, 'index']);
    Route::post('/v1/system-modulo-menu', [SystemModuloMenuController::class, 'store']);
    Route::post('/v1/system-modulo-menu/{systemModuloMenu}', [SystemModuloMenuController::class, 'update']);
    Route::post('/v1/system-modulo/{systemModulo}', [SystemModuloController::class, 'update']);
    Route::get('/v1/system-modulo/{systemModulo}', [SystemModuloController::class, 'show']);
    Route::post('/v1/system-modulos', [SystemController::class, 'systemModulos']);
    // SYSTEM MENUS

    // SYSTEM USUARIOS
    Route::get('/v1/system-usuario', [SystemController::class, 'usuarios']);
    
    // SYSTEM USUARIOS

    // SYSTEM ROLES
    Route::get('/v1/system-roles', [SystemRolController::class, 'index']);
    // SYSTEM ROLES

    // SYSTEM ACCESOS
    Route::post('/v1/system-accesos-setup', [SystemAccesoModuloController::class, 'setup']);
    // SYSTEM ACCESOS

    Route::post('/v1/logout', [AuthController::class, 'logout']);
});
