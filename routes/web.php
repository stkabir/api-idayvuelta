<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redireccionar /login a /admin/login
Route::get('/login', function () {
    return redirect('/admin/login');
});
