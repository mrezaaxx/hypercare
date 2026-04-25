<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LabOrderController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RadiologyOrderController;
use App\Http\Controllers\SimrsPrototypeController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [SimrsPrototypeController::class, 'index'])->name('home');
    Route::get('/simrs', [SimrsPrototypeController::class, 'index'])->name('simrs.dashboard');
    Route::resource('patients', PatientController::class)->except(['show']);
    Route::resource('lab-orders', LabOrderController::class)->except(['show']);
    Route::resource('radiology-orders', RadiologyOrderController::class)->except(['show']);
});
