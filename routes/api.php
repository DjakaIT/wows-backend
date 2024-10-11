<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\BattleParticipantController;
use App\Http\Controllers\PlayerShipController;
use App\Http\Controllers\PlayerAchievementController;
use App\Http\Controllers\PlayerStatisticController;
use App\Http\Controllers\ClanMemberController;



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



Route::prefix('achievements')->group(function () {
    Route::get('/', [AchievementController::class, 'index']);
    Route::get('/{id}', [AchievementController::class, 'show']);
    Route::post('/', [AchievementController::class, 'store']);
    Route::put('/{id}', [AchievementController::class, 'update']);
    Route::delete('/{id}', [AchievementController::class, 'destroy']);
});

Route::prefix('player-achievements')->group(function () {
    Route::get('/', [PlayerAchievementController::class, 'index']);
    Route::get('/{id}', [PlayerAchievementController::class, 'show']);
    Route::post('/', [PlayerAchievementController::class, 'store']);
    Route::put('/{id}', [PlayerAchievementController::class, 'update']);
    Route::delete('/{id}', [PlayerAchievementController::class, 'destroy']);
});


Route::prefix('player-statistics')->group(function () {
    Route::get('/', [PlayerStatisticController::class, 'index']);
    Route::get('/{id}', [PlayerStatisticController::class, 'show']);
    Route::post('/', [PlayerStatisticController::class, 'store']);
    Route::put('/{id}', [PlayerStatisticController::class, 'update']);
    Route::delete('/{id}', [PlayerStatisticController::class, 'destroy']);
});



Route::prefix('player-ships')->group(function () {
    Route::get('/', [PlayerShipController::class, 'index']);
    Route::get('/{id}', [PlayerShipController::class, 'show']);
    Route::post('/', [PlayerShipController::class, 'store']);
    Route::put('/{id}', [PlayerShipController::class, 'update']);
    Route::delete('/{id}', [PlayerShipController::class, 'destroy']);
});


Route::prefix('clan-members')->group(function () {
    Route::get('/', [ClanMemberController::class, 'index']);
    Route::get('/{id}', [ClanMemberController::class, 'show']);
    Route::post('/', [ClanMemberController::class, 'store']);
    Route::put('/{id}', [ClanMemberController::class, 'update']);
    Route::delete('/{id}', [ClanMemberController::class, 'destroy']);
});



Route::prefix('battle-participants')->group(function () {
    Route::get('/', [BattleParticipantController::class, 'index']);
    Route::get('/{id}', [BattleParticipantController::class, 'show']);
    Route::post('/', [BattleParticipantController::class, 'store']);
    Route::put('/{id}', [BattleParticipantController::class, 'update']);
    Route::delete('/{id}', [BattleParticipantController::class, 'destroy']);
});
