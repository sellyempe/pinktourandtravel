<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

// Landing Page
Route::get('/', function () {
    return view('landing');
});

// Destination Detail Page
Route::get('/destination/{id}', [DestinationController::class, 'show'])->name('destination.show');

// Trip Detail Page
Route::get('/trip/{id}', [TripController::class, 'detail'])->name('trip.detail');

// Booking Routes
Route::middleware('auth')->prefix('booking')->group(function () {
    Route::get('/create/{trip_id}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/{id}/confirmation', [BookingController::class, 'confirmation'])->name('booking.confirmation');
    Route::get('/', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Midtrans Webhook - CSRF Exception
Route::post('/midtrans-webhook', [BookingController::class, 'handleNotification'])->name('midtrans.webhook');

// Auth Routes
Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

Route::get('/register', [RegisterController::class, 'show'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Trips
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/trips/create', [AdminController::class, 'createTrip'])->name('admin.trips.create');
    Route::post('/trips', [AdminController::class, 'storeTrip'])->name('admin.trips.store');
    Route::get('/trips/{id}/edit', [AdminController::class, 'editTrip'])->name('admin.trips.edit');
    Route::put('/trips/{id}', [AdminController::class, 'updateTrip'])->name('admin.trips.update');
    Route::delete('/trips/{id}', [AdminController::class, 'destroyTrip'])->name('admin.trips.destroy');
    
    // Destinations
    Route::get('/destinations', [AdminController::class, 'destinationsDashboard'])->name('admin.destinations.dashboard');
    Route::get('/destinations/create', [AdminController::class, 'createDestination'])->name('admin.destinations.create');
    Route::post('/destinations', [AdminController::class, 'storeDestination'])->name('admin.destinations.store');
    Route::get('/destinations/{id}/edit', [AdminController::class, 'editDestination'])->name('admin.destinations.edit');
    Route::put('/destinations/{id}', [AdminController::class, 'updateDestination'])->name('admin.destinations.update');
    Route::delete('/destinations/{id}', [AdminController::class, 'destroyDestination'])->name('admin.destinations.destroy');

    // Settings
    Route::get('/settings', [AdminController::class, 'settingsDashboard'])->name('admin.settings.dashboard');
    Route::get('/settings/{id}/edit', [AdminController::class, 'editSetting'])->name('admin.settings.edit');
    Route::put('/settings/{id}', [AdminController::class, 'updateSetting'])->name('admin.settings.update');

    // Reviews (approve/reject)
    Route::get('/reviews', [AdminController::class, 'reviewsDashboard'])->name('admin.reviews.dashboard');
    Route::put('/reviews/{id}/approve', [AdminController::class, 'approveReview'])->name('admin.reviews.approve');
    Route::put('/reviews/{id}/reject', [AdminController::class, 'rejectReview'])->name('admin.reviews.reject');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        return view('landing');
    })->name('user.dashboard');
});

