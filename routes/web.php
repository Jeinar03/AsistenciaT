<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
});

// Rutas Maestro
Route::middleware(['auth', 'role:maestro'])->prefix('maestro')->name('maestro.')->group(function () {
    Route::get('/dashboard', function () {
        return view('maestro.dashboard');
    })->name('dashboard');
});

// Rutas Alumno
Route::middleware(['auth', 'role:alumno'])->prefix('alumno')->name('alumno.')->group(function () {
    Route::get('/dashboard', function () {
        return view('alumno.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';