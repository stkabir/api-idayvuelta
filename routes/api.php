<?php

use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\HotelController;
use App\Http\Controllers\Api\V1\PromotionController;
use App\Http\Controllers\Api\V1\SiteConfigController;
use App\Http\Controllers\Api\V1\TourController;
use App\Http\Controllers\Api\V1\TransferController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ─────────────────────────────────────────────────────────────────────────────
// Auth (Sanctum)
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ─────────────────────────────────────────────────────────────────────────────
// API v1 — rutas principales
// ─────────────────────────────────────────────────────────────────────────────

Route::prefix('v1')->name('v1.')->group(function () {

    // Listado y detalle de servicios (solo lectura, pública)
    Route::apiResource('hotels', HotelController::class)->only(['index', 'show']);
    Route::apiResource('tours', TourController::class)->only(['index', 'show']);
    Route::apiResource('transfers', TransferController::class)->only(['index', 'show']);

    // Banners por posición
    Route::get('banners', [BannerController::class, 'index'])->name('banners.index');

    // Reservas (crear y consultar por número de reserva)
    Route::post('bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('bookings/{booking_number}', [BookingController::class, 'show'])->name('bookings.show');

    // Validación de código promocional
    Route::post('promotions/validate', [PromotionController::class, 'validateCode'])->name('promotions.validate');

    // Configuración del sitio (branding, colores, servicios) — público, sin auth
    Route::get('config', [SiteConfigController::class, 'show'])->name('config.show');
});

// ─────────────────────────────────────────────────────────────────────────────
// Compatibilidad hacia atrás — redirige /api/* → /api/v1/*
// El frontend Astro sigue funcionando sin cambios
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/hotels', fn () => redirect()->to('/api/v1/hotels' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')));
Route::get('/hotels/{slug}', fn (string $slug) => redirect()->to("/api/v1/hotels/{$slug}"));
Route::get('/tours', fn () => redirect()->to('/api/v1/tours' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')));
Route::get('/tours/{slug}', fn (string $slug) => redirect()->to("/api/v1/tours/{$slug}"));
Route::get('/transfers', fn () => redirect()->to('/api/v1/transfers' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')));
Route::get('/transfers/{slug}', fn (string $slug) => redirect()->to("/api/v1/transfers/{$slug}"));
Route::get('/banners', fn () => redirect()->to('/api/v1/banners' . (request()->getQueryString() ? '?' . request()->getQueryString() : '')));
