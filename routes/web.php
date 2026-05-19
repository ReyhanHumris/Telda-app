<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndibizController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/indibiz', [IndibizController::class, 'index'])->name('indibiz.index');
    Route::get('/indibiz/create', [IndibizController::class, 'create'])->name('indibiz.create');
    Route::post('/indibiz', [IndibizController::class, 'store'])->name('indibiz.store');
    Route::delete('/indibiz/{indibiz}', [IndibizController::class, 'destroy'])->name('indibiz.destroy');
    Route::get('/indibiz/trash', [IndibizController::class, 'trash'])->name('indibiz.trash');
    Route::post('/indibiz/{id}/restore', [IndibizController::class, 'restore'])->name('indibiz.restore');
    Route::delete('/indibiz/{id}/force', [IndibizController::class, 'forceDelete'])->name('indibiz.forceDelete');

    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
    Route::get('/survey/create', [SurveyController::class, 'create'])->name('survey.create');
    Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
    Route::delete('/survey/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');
    Route::get('/survey/trash', [SurveyController::class, 'trash'])->name('survey.trash');
    Route::post('/survey/{id}/restore', [SurveyController::class, 'restore'])->name('survey.restore');
    Route::delete('/survey/{id}/force', [SurveyController::class, 'forceDelete'])->name('survey.forceDelete');

    Route::middleware('role:admin')->group(function () {
        Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas/create', [AktivitasController::class, 'create'])->name('aktivitas.create');
        Route::post('/aktivitas', [AktivitasController::class, 'store'])->name('aktivitas.store');
        Route::delete('/aktivitas/{aktivitas}', [AktivitasController::class, 'destroy'])->name('aktivitas.destroy');
        Route::get('/aktivitas/trash', [AktivitasController::class, 'trash'])->name('aktivitas.trash');
        Route::post('/aktivitas/{id}/restore', [AktivitasController::class, 'restore'])->name('aktivitas.restore');
        Route::delete('/aktivitas/{id}/force', [AktivitasController::class, 'forceDelete'])->name('aktivitas.forceDelete');

        Route::get('/pengguna/trashed', [PenggunaController::class, 'trashed'])->name('pengguna.trashed');
        Route::get('/pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::post('/pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
        Route::put('/pengguna/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('/pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
        Route::post('/pengguna/{id}/restore', [PenggunaController::class, 'restore'])->name('pengguna.restore');
        Route::delete('/pengguna/{id}/force', [PenggunaController::class, 'forceDelete'])->name('pengguna.forceDelete');
    });
});
