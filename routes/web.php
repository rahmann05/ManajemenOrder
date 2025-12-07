<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia; // [Baru]

Route::get('/', function () {
    return Inertia::render('Welcome'); // [Ubah dari view('welcome') ke Inertia::render]
});