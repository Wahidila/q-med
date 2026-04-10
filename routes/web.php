<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ServiceHistoryController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

// Kiosk (public, no auth)
Route::get('/kiosk', [KioskController::class , 'index'])->name('kiosk');

// Admin (auth required)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class , 'index'])->name('dashboard');

    // Registration
    Route::get('/registration', [RegistrationController::class , 'index'])->name('registration.index');
    Route::post('/registration', [RegistrationController::class , 'store'])->name('registration.store');
    Route::get('/patients/search', [RegistrationController::class , 'searchPatient'])->name('patients.search');

    // Queue management
    Route::get('/queue', [QueueController::class , 'index'])->name('queue.index');
    Route::post('/queue/call-next', [QueueController::class , 'callNext'])->name('queue.callNext');
    Route::post('/queue/{queue}/start', [QueueController::class , 'startService'])->name('queue.startService');
    Route::post('/queue/{queue}/complete', [QueueController::class , 'completeService'])->name('queue.completeService');
    Route::post('/queue/{queue}/skip', [QueueController::class , 'skipQueue'])->name('queue.skip');

    // Patients CRUD
    Route::resource('patients', PatientController::class)->except(['show']);

    // Service history
    Route::get('/services', [ServiceHistoryController::class , 'index'])->name('services.index');
});
