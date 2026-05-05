<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IgdController;
use App\Http\Controllers\InpatientController;
use App\Http\Controllers\LabOrderController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RadiologyOrderController;
use App\Http\Controllers\SimrsPrototypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BedController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\PolyclinicAppointmentController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/debug-log', function () {
    $log = file_get_contents('/tmp/hypercare-error.log');
    return response($log ?: 'no errors logged', 200)->header('Content-Type', 'text/plain');
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/', [SimrsPrototypeController::class, 'index'])->name('home');
    Route::get('/simrs', [SimrsPrototypeController::class, 'index'])->name('simrs.dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::resource('doctors', DoctorController::class)->except(['show']);
        Route::resource('rooms', RoomController::class)->except(['show']);
        Route::resource('beds', BedController::class)->except(['show']);
        Route::resource('doctor-schedules', DoctorScheduleController::class)->except(['show']);
    });

    Route::middleware('role:admin,doctor,nurse,staff')->group(function () {
        Route::resource('patients', PatientController::class)->except(['show']);
    });

    Route::middleware('role:admin,doctor')->group(function () {
        Route::resource('lab-orders', LabOrderController::class)->except(['show']);
        Route::resource('radiology-orders', RadiologyOrderController::class)->except(['show']);
    });

    Route::middleware('role:admin,doctor,nurse')->group(function () {
        Route::resource('igd', IgdController::class)->except(['show']);
        Route::resource('inpatient', InpatientController::class)->except(['show']);
        Route::resource('polyclinic-appointments', PolyclinicAppointmentController::class)->except(['show']);
    });
});
