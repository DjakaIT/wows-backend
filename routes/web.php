<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ShipController;
use App\Http\Controllers\ClanMemberController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\PlayerAchievementController;
use App\Http\Controllers\PlayerShipController;
use App\Http\Controllers\PlayerStatisticController;

Route::get('/', function () {
    // DATA INFO
    // 1. List of 10 best players today
    // 2. List of 10 best players last 7 days
    // 3. List of 10 best players last month (25 days)
    // 4. List of 10 best players overall (28 days)
    // 5. List of 10 best Clans
    return Inertia::render('Home', [
        'statistics' => [
            'topPlayersLast24Hours' => [
                ['name' => 'player 1', 'wid' => 234, 'wn8' => 2334],
                ['name' => 'player 2', 'wid' => 234, 'wn8' => 2245],
                ['name' => 'player 3', 'wid' => 234, 'wn8' => 1988],
                ['name' => 'player 4', 'wid' => 234, 'wn8' => 1800],
                ['name' => 'player 5', 'wid' => 234, 'wn8' => 1788],
                ['name' => 'player 6', 'wid' => 234, 'wn8' => 1501],
                ['name' => 'player 7', 'wid' => 234, 'wn8' => 1400],
                ['name' => 'player 8', 'wid' => 234, 'wn8' => 985],
                ['name' => 'player 9', 'wid' => 234, 'wn8' => 300],
                ['name' => 'player 10', 'wid' => 234, 'wn8' => 204],
            ],
            'topPlayersLastSevenDays' => [
                ['name' => 'player 1', 'wid' => 234, 'wn8' => 2334],
                ['name' => 'player 2', 'wid' => 234, 'wn8' => 2245],
                ['name' => 'player 3', 'wid' => 234, 'wn8' => 1988],
                ['name' => 'player 4', 'wid' => 234, 'wn8' => 1800],
                ['name' => 'player 5', 'wid' => 234, 'wn8' => 1788],
                ['name' => 'player 6', 'wid' => 234, 'wn8' => 1501],
                ['name' => 'player 7', 'wid' => 234, 'wn8' => 1400],
                ['name' => 'player 8', 'wid' => 234, 'wn8' => 985],
                ['name' => 'player 9', 'wid' => 234, 'wn8' => 300],
                ['name' => 'player 10', 'wid' => 234, 'wn8' => 204],
            ],
            'topPlayersLastMonth' => [
                ['name' => 'player 1', 'wid' => 234, 'wn8' => 2334],
                ['name' => 'player 2', 'wid' => 234, 'wn8' => 2245],
                ['name' => 'player 3', 'wid' => 234, 'wn8' => 1988],
                ['name' => 'player 4', 'wid' => 234, 'wn8' => 1800],
                ['name' => 'player 5', 'wid' => 234, 'wn8' => 1788],
                ['name' => 'player 6', 'wid' => 234, 'wn8' => 1501],
                ['name' => 'player 7', 'wid' => 234, 'wn8' => 1400],
                ['name' => 'player 8', 'wid' => 234, 'wn8' => 985],
                ['name' => 'player 9', 'wid' => 234, 'wn8' => 300],
                ['name' => 'player 10', 'wid' => 234, 'wn8' => 204],
            ],
            'topPlayersOverall' => [
                ['name' => 'player 1', 'wid' => 234, 'wn8' => 2334],
                ['name' => 'player 2', 'wid' => 234, 'wn8' => 2245],
                ['name' => 'player 3', 'wid' => 234, 'wn8' => 1988],
                ['name' => 'player 4', 'wid' => 234, 'wn8' => 1800],
                ['name' => 'player 5', 'wid' => 234, 'wn8' => 1788],
                ['name' => 'player 6', 'wid' => 234, 'wn8' => 1501],
                ['name' => 'player 7', 'wid' => 234, 'wn8' => 1400],
                ['name' => 'player 8', 'wid' => 234, 'wn8' => 985],
                ['name' => 'player 9', 'wid' => 234, 'wn8' => 300],
                ['name' => 'player 10', 'wid' => 234, 'wn8' => 204],
            ],
            'topClans' => [
                ['name' => 'clan 1', 'wid' => 234, 'wn8' => 2334],
                ['name' => 'clan 2', 'wid' => 234, 'wn8' => 2245],
                ['name' => 'clan 3', 'wid' => 234, 'wn8' => 1988],
                ['name' => 'clan 4', 'wid' => 234, 'wn8' => 1800],
                ['name' => 'clan 5', 'wid' => 234, 'wn8' => 1788],
                ['name' => 'clan 6', 'wid' => 234, 'wn8' => 1501],
                ['name' => 'clan 7', 'wid' => 234, 'wn8' => 1400],
                ['name' => 'clan 8', 'wid' => 234, 'wn8' => 985],
                ['name' => 'clan 9', 'wid' => 234, 'wn8' => 300],
                ['name' => 'clan 10', 'wid' => 234, 'wn8' => 204],
            ],
        ]
    ]);
});

Route::get('/player/{id}', function () {
    // DATA INFO
    // 1. Player information
    // 2. Player statistics 1,7,month, overall
    // 3. Player ships
    return Inertia::render('Player');
});

Route::get('/clan/{id}', function () {
    // DATA INFO
    // 1. Clan information
    // 2. Clan players with their wn8
    return Inertia::render('Clan');
});

Route::get('/wiki', function () {
    return Inertia::render('Wiki');
});


Route::prefix('clans')->group(function () {

    Route::get('/fetch', [ClanController::class, 'fetchAndStoreClans']);
    Route::get('/', [ClanController::class, 'index']);
    Route::get('/{id}', [ClanController::class, 'show']);
    Route::post('/', [ClanController::class, 'store']);
    Route::put('/{id}', [ClanController::class, 'update']);
    Route::delete('/{id}', [ClanController::class, 'destroy']);
});

Route::prefix('players')->group(function () {

    Route::get('/fetch', [PlayerController::class, 'fetchAndStorePlayers']);
    Route::get('/', [PlayerController::class, 'index']);
    Route::get('/{id}', [PlayerController::class, 'show']);
    Route::post('/', [PlayerController::class, 'store']);
    Route::put('/{id}', [PlayerController::class, 'update']);
    Route::delete('/{id}', [PlayerController::class, 'destroy']);
});



Route::prefix('ships')->group(function () {

    Route::get('/fetch', [ShipController::class, 'fetchAndStoreShips']);
    Route::get('/', [ShipController::class, 'index']);
    Route::get('/{id}', [ShipController::class, 'show']);
    Route::post('/', [ShipController::class, 'store']);
    Route::put('/{id}', [ShipController::class, 'update']);
    Route::delete('/{id}', [ShipController::class, 'destroy']);
});


Route::prefix('clan-members')->group(function () {

    Route::get('/fetch', [ClanMemberController::class, 'updateClanMembers']);
    Route::get('/', [ClanMemberController::class, 'index']);
    Route::get('/{id}', [ClanMemberController::class, 'show']);
    Route::post('/', [ClanMemberController::class, 'store']);
    Route::put('/{id}', [ClanMemberController::class, 'update']);
    Route::delete('/{id}', [ClanMemberController::class, 'destroy']);
});

Route::prefix('achievements')->group(function () {

    Route::get('/fetch', [AchievementController::class, 'fetchAndStoreAchievements']);
    Route::get('/', [AchievementController::class, 'index']);
    Route::get('/{id}', [AchievementController::class, 'show']);
    Route::post('/', [AchievementController::class, 'store']);
    Route::put('/{id}', [AchievementController::class, 'update']);
    Route::delete('/{id}', [AchievementController::class, 'destroy']);
});

Route::prefix('player-achievements')->group(function () {

    Route::get('/fetch', [PlayerAchievementController::class, 'storePlayerAchievements']);
    Route::get('/', [PlayerAchievementController::class, 'index']);
    Route::get('/{id}', [PlayerAchievementController::class, 'show']);
    Route::post('/', [PlayerAchievementController::class, 'store']);
    Route::put('/{id}', [PlayerAchievementController::class, 'update']);
    Route::delete('/{id}', [PlayerAchievementController::class, 'destroy']);
});



Route::prefix('player-ships')->group(function () {

    Route::get('/fetch', [PlayerShipController::class, 'updatePlayerShips']);
    Route::get('/', [PlayerShipController::class, 'index']);
    Route::get('/{id}', [PlayerShipController::class, 'show']);
    Route::post('/', [PlayerShipController::class, 'store']);
    Route::put('/{id}', [PlayerShipController::class, 'update']);
    Route::delete('/{id}', [PlayerShipController::class, 'destroy']);
});


Route::prefix('player-stats')->group(function () {

    Route::get('/fetch', [PlayerStatisticController::class, 'updatePlayerStats']);
    Route::get('/', [PlayerStatisticController::class, 'index']);
    Route::get('/{id}', [PlayerStatisticController::class, 'show']);
    Route::post('/', [PlayerStatisticController::class, 'store']);
    Route::put('/{id}', [PlayerStatisticController::class, 'update']);
    Route::delete('/{id}', [PlayerStatisticController::class, 'destroy']);
});


Route::prefix('clans')->group(function () {

    Route::get('/fetch', [ClanController::class, 'fetchAndStoreClans']);
    Route::get('/', [ClanController::class, 'index']);
    Route::get('/{id}', [ClanController::class, 'show']);
    Route::post('/', [ClanController::class, 'store']);
    Route::put('/{id}', [ClanController::class, 'update']);
    Route::delete('/{id}', [ClanController::class, 'destroy']);
});

Route::prefix('players')->group(function () {

    Route::get('/fetch', [PlayerController::class, 'fetchAndStorePlayers']);
    Route::get('/', [PlayerController::class, 'index']);
    Route::get('/{id}', [PlayerController::class, 'show']);
    Route::post('/', [PlayerController::class, 'store']);
    Route::put('/{id}', [PlayerController::class, 'update']);
    Route::delete('/{id}', [PlayerController::class, 'destroy']);
});



Route::prefix('ships')->group(function () {

    Route::get('/fetch', [ShipController::class, 'fetchAndStoreShips']);
    Route::get('/', [ShipController::class, 'index']);
    Route::get('/{id}', [ShipController::class, 'show']);
    Route::post('/', [ShipController::class, 'store']);
    Route::put('/{id}', [ShipController::class, 'update']);
    Route::delete('/{id}', [ShipController::class, 'destroy']);
});


Route::prefix('clan-members')->group(function () {

    Route::get('/fetch', [ClanMemberController::class, 'updateClanMembers']);
    Route::get('/', [ClanMemberController::class, 'index']);
    Route::get('/{id}', [ClanMemberController::class, 'show']);
    Route::post('/', [ClanMemberController::class, 'store']);
    Route::put('/{id}', [ClanMemberController::class, 'update']);
    Route::delete('/{id}', [ClanMemberController::class, 'destroy']);
});

Route::prefix('achievements')->group(function () {

    Route::get('/fetch', [AchievementController::class, 'fetchAndStoreAchievements']);
    Route::get('/', [AchievementController::class, 'index']);
    Route::get('/{id}', [AchievementController::class, 'show']);
    Route::post('/', [AchievementController::class, 'store']);
    Route::put('/{id}', [AchievementController::class, 'update']);
    Route::delete('/{id}', [AchievementController::class, 'destroy']);
});

Route::prefix('player-achievements')->group(function () {

    Route::get('/fetch', [PlayerAchievementController::class, 'storePlayerAchievements']);
    Route::get('/', [PlayerAchievementController::class, 'index']);
    Route::get('/{id}', [PlayerAchievementController::class, 'show']);
    Route::post('/', [PlayerAchievementController::class, 'store']);
    Route::put('/{id}', [PlayerAchievementController::class, 'update']);
    Route::delete('/{id}', [PlayerAchievementController::class, 'destroy']);
});



Route::prefix('player-ships')->group(function () {

    Route::get('/fetch', [PlayerShipController::class, 'updatePlayerShips']);
    Route::get('/', [PlayerShipController::class, 'index']);
    Route::get('/{id}', [PlayerShipController::class, 'show']);
    Route::post('/', [PlayerShipController::class, 'store']);
    Route::put('/{id}', [PlayerShipController::class, 'update']);
    Route::delete('/{id}', [PlayerShipController::class, 'destroy']);
});


Route::prefix('player-stats')->group(function () {

    Route::get('/fetch', [PlayerStatisticController::class, 'updatePlayerStats']);
    Route::get('/', [PlayerStatisticController::class, 'index']);
    Route::get('/{id}', [PlayerStatisticController::class, 'show']);
    Route::post('/', [PlayerStatisticController::class, 'store']);
    Route::put('/{id}', [PlayerStatisticController::class, 'update']);
    Route::delete('/{id}', [PlayerStatisticController::class, 'destroy']);
});

Route::get('/wiki/nations', function () {
    return Inertia::render('WikiNations');
});

Route::get('/wiki/type', function () {
    return Inertia::render('WikiType');
});

Route::get('/wiki/vehicle/{vehicle_name}', function () {
    return Inertia::render('WikiVehicle');
});

Route::get('/FAQ', function () {
    return Inertia::render('FAQ');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});

Route::get('/imprint', function () {
    return Inertia::render('Imprint');
});

Route::get('/imprint', function () {
    return Inertia::render('Imprint');
});

Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::get('/notfound', function () {
    // Proveriti kako se ovde ruta stavlja
    return Inertia::render('NotFound');
});

Route::get('/privacy', function () {
    return Inertia::render('PrivacyPolicy');
});

Route::get('/rating', function () {
    return Inertia::render('Rating');
});

Route::get('/wiki/nations', function () {
    return Inertia::render('WikiNations');
});

Route::get('/wiki/type', function () {
    return Inertia::render('WikiType');
});

Route::get('/wiki/vehicle/{vehicle_name}', function () {
    return Inertia::render('WikiVehicle');
});

Route::get('/FAQ', function () {
    return Inertia::render('FAQ');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
});

Route::get('/imprint', function () {
    return Inertia::render('Imprint');
});

Route::get('/imprint', function () {
    return Inertia::render('Imprint');
});

Route::get('/login', function () {
    return Inertia::render('Login');
});

Route::get('/notfound', function () {
    // Proveriti kako se ovde ruta stavlja
    return Inertia::render('NotFound');
});

Route::get('/privacy', function () {
    return Inertia::render('PrivacyPolicy');
});

Route::get('/rating', function () {
    return Inertia::render('Rating');
});
