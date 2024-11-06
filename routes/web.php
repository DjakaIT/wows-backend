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