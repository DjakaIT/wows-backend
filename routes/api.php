<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ShipController;


//routes for players
Route::prefix('players')->group(function () {

    Route::get('/', [PlayerController::class, 'index']);
    Route::get('/{id}', [PlayerController::class, 'show']);
    Route::post('/', [PlayerController::class, 'store']);
    Route::put('/{id}', [PlayerController::class, 'update']);
    Route::delete('/{id}', [PlayerController::class, 'destroy']);
});

Route::prefix('ships')->group(function () {
    Route::get('/', [ShipController::class, 'index']);
    Route::get('/{id}', [ShipController::class, 'show']);
    Route::post('/', [ShipController::class, 'store']);
    Route::put('/{id}', [ShipController::class, 'update']);
    Route::delete('/{id}', [ShipController::class, 'destroy']);
});


Route::prefix('clans')->group(function () {
    Route::get('/', [ClanController::class, 'index']);
    Route::get('/{id}', [ClanController::class, 'show']);
    Route::post('/', [ClanController::class, 'store']);
    Route::put('/{id}', [ClanController::class, 'update']);
    Route::delete('/{id}', [ClanController::class, 'destroy']);
});



Route::prefix('battles')->group(function () {
    Route::get('/', [BattleController::class, 'index']);
    Route::get('/{id}', [BattleController::class, 'show']);
    Route::post('/', [BattleController::class, 'store']);
    Route::put('/{id}', [BattleController::class, 'update']);
    Route::delete('/{id}', [BattleController::class, 'destroy']);
});
