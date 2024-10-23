<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Home', [
        'user' => 'Kralj Tomislav'
    ]);
});

Route::get('/wiki', function () {
    return Inertia::render('Wiki');
});
