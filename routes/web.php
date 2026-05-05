<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect('/admin/login'));

// Redireccionar /login a /admin/login
Route::get('/login', fn () => redirect('/admin/login'));

// Guía de usuario del panel de administración
Route::view('/dashboard-guia-usuario', 'user-guide');
