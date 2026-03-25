<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Maestro\DashboardController as MaestroDashboard;
use App\Http\Controllers\Admin\SemestreController;
use App\Http\Controllers\Admin\CarreraController;
use App\Http\Controllers\Admin\MateriaController;
use App\Http\Controllers\Admin\GrupoController;
use App\Http\Controllers\Maestro\AsistenciaController;
use App\Http\Controllers\Admin\InscripcionController;
use App\Http\Controllers\Maestro\CriterioController;
use App\Http\Controllers\Maestro\CalificacionController;
use App\Http\Controllers\Maestro\ReporteController;
use App\Http\Controllers\Alumno\DashboardController as AlumnoDashboard;
use App\Http\Controllers\Alumno\MiAsistenciaController;
use App\Http\Controllers\Alumno\MiCalificacionController;
use App\Http\Controllers\Admin\AuditoriaController;


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
    Route::resource('semestres', SemestreController::class);
    Route::resource('carreras', CarreraController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grupos', GrupoController::class);
    Route::get('/grupos/{grupo}/inscripciones', [InscripcionController::class, 'index'])->name('inscripciones.index');
Route::post('/grupos/{grupo}/inscripciones', [InscripcionController::class, 'inscribir'])->name('inscripciones.inscribir');
Route::delete('/grupos/{grupo}/inscripciones/{alumno}', [InscripcionController::class, 'desinscribir'])->name('inscripciones.desinscribir');
Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');
});
// Rutas Maestro
Route::middleware(['auth', 'role:maestro'])->prefix('maestro')->name('maestro.')->group(function () {
    Route::get('/dashboard', [MaestroDashboard::class, 'index'])->name('dashboard');

    // Asistencia
    Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('asistencia.index');
    Route::get('/asistencia/{grupo}/sesiones', [AsistenciaController::class, 'sesiones'])->name('asistencia.sesiones');
    Route::get('/asistencia/{sesion}/tomar', [AsistenciaController::class, 'tomar'])->name('asistencia.tomar');
    Route::post('/asistencia/{sesion}/guardar', [AsistenciaController::class, 'guardar'])->name('asistencia.guardar');
    Route::get('/asistencia/{grupo}/reporte', [AsistenciaController::class, 'reporte'])->name('asistencia.reporte');
    Route::get('/grupos/{grupo}/reporte-asistencia-pdf', [ReporteController::class, 'asistenciaPdf'])->name('reporte.asistencia.pdf');
    Route::get('/grupos/{grupo}/reporte-calificaciones-pdf', [ReporteController::class, 'calificacionesPdf'])->name('reporte.calificaciones.pdf');
    // Criterios
Route::get('/grupos/{grupo}/criterios', [CriterioController::class, 'index'])->name('criterios.index');
Route::post('/grupos/{grupo}/criterios', [CriterioController::class, 'store'])->name('criterios.store');
Route::delete('/grupos/{grupo}/criterios/{criterio}', [CriterioController::class, 'destroy'])->name('criterios.destroy');

// Calificaciones
Route::get('/grupos/{grupo}/calificaciones', [CalificacionController::class, 'index'])->name('calificaciones.index');
Route::post('/grupos/{grupo}/calificaciones', [CalificacionController::class, 'guardar'])->name('calificaciones.guardar');
});

// Rutas Alumno
Route::middleware(['auth', 'role:alumno'])->prefix('alumno')->name('alumno.')->group(function () {
    Route::get('/dashboard', [AlumnoDashboard::class, 'index'])->name('dashboard');
    Route::get('/grupos/{grupo}/asistencia', [MiAsistenciaController::class, 'index'])->name('mi.asistencia');
    Route::get('/grupos/{grupo}/calificaciones', [MiCalificacionController::class, 'index'])->name('mi.calificaciones');
});

require __DIR__.'/auth.php';
