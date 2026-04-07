<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentTransactionController;
use App\Http\Controllers\SettingsController;

Route::middleware('api')->group(function () {
    // Destination CRUD API Routes
    Route::prefix('destinations')->group(function () {
        // GET /api/destinations - Ambil semua
        Route::get('/', [DestinationController::class, 'index']);

        // POST /api/destinations - Buat baru
        Route::post('/', [DestinationController::class, 'store']);

        // GET /api/destinations/{id} - Ambil satu
        Route::get('/{id}', [DestinationController::class, 'getDetail']);

        // PUT /api/destinations/{id} - Update
        Route::put('/{id}', [DestinationController::class, 'update']);

        // DELETE /api/destinations/{id} - Hapus
        Route::delete('/{id}', [DestinationController::class, 'destroy']);
    });

    // Trip CRUD API Routes
    Route::prefix('trips')->group(function () {
        // GET /api/trips - Ambil semua
        Route::get('/', [TripController::class, 'index']);

        // POST /api/trips - Buat baru
        Route::post('/', [TripController::class, 'store']);

        // GET /api/trips/{id} - Ambil satu dengan details
        Route::get('/{id}', [TripController::class, 'show']);

        // PUT /api/trips/{id} - Update
        Route::put('/{id}', [TripController::class, 'update']);

        // DELETE /api/trips/{id} - Hapus
        Route::delete('/{id}', [TripController::class, 'destroy']);
    });

    // Public Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index']);
        Route::get('/by-key/{key}', [SettingsController::class, 'getByKey']);
        Route::get('/by-category/{category}', [SettingsController::class, 'getByCategory']);
    });

    // Public Review Routes
    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index']);
        Route::get('/{type}/{itemId}', [ReviewController::class, 'getByItem']);
    });

    // Protected Routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // Wishlist Routes
        Route::prefix('wishlists')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('/', [WishlistController::class, 'store']);
            Route::delete('/{id}', [WishlistController::class, 'destroy']);
            Route::delete('/item/{type}/{itemId}', [WishlistController::class, 'destroyByItem']);
            Route::get('/check/{type}/{itemId}', [WishlistController::class, 'check']);
        });

        // Review Routes (protected)
        Route::prefix('reviews')->group(function () {
            Route::post('/', [ReviewController::class, 'store']);
            Route::put('/{id}', [ReviewController::class, 'update']);
            Route::delete('/{id}', [ReviewController::class, 'destroy']);
        });

        // Payment Routes
        Route::prefix('payments')->group(function () {
            Route::get('/', [PaymentTransactionController::class, 'index']);
            Route::get('/{id}', [PaymentTransactionController::class, 'show']);
            Route::post('/', [PaymentTransactionController::class, 'store']);
            Route::put('/{id}', [PaymentTransactionController::class, 'update']);
            Route::get('/by-reference/{referenceId}', [PaymentTransactionController::class, 'getByReference']);
        });

        // Admin Settings Routes (admin only)
        Route::prefix('settings')->group(function () {
            Route::post('/', [SettingsController::class, 'store'])->middleware('admin');
            Route::put('/{id}', [SettingsController::class, 'update'])->middleware('admin');
            Route::delete('/{id}', [SettingsController::class, 'destroy'])->middleware('admin');
        });
    });
});

