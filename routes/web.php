<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // DATA INFO
    // 1. List of 10 best players today
    // 2. List of 10 best players last 7 days
    // 3. List of 10 best players last month (28 days)
    // 4. List of 10 best Clans
    return Inertia::render('Home', [
        'user' => 'Kralj Tomislav'
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

Route::get('/wiki/nations', function () {
    return Inertia::render('WikiNations');
});

Route::get('/wiki/type', function () {
    return Inertia::render('WikiType');
});

Route::get('/wiki/vehicle/{vehicle_name}', function () {
    return Inertia::render('WikiVehicle');
});
