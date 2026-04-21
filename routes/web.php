<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IndibizController;
use App\Http\Controllers\SurveyController;

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

    Route::get('/indibiz', [IndibizController::class, 'index'])->name('indibiz.index');
    Route::get('/indibiz/create', [IndibizController::class, 'create'])->name('indibiz.create');
    Route::post('/indibiz', [IndibizController::class, 'store'])->name('indibiz.store');
    Route::delete('/indibiz/{indibiz}', [IndibizController::class, 'destroy'])->name('indibiz.destroy');

    Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
    Route::get('/survey/create', [SurveyController::class, 'create'])->name('survey.create');
    Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
    Route::delete('/survey/{survey}', [SurveyController::class, 'destroy'])->name('survey.destroy');

    Route::middleware('role:admin')->group(function () {
        Route::get('/aktivitas', [AktivitasController::class, 'index'])->name('aktivitas.index');
        Route::get('/aktivitas/create', [AktivitasController::class, 'create'])->name('aktivitas.create');
        Route::post('/aktivitas', [AktivitasController::class, 'store'])->name('aktivitas.store');
        Route::delete('/aktivitas/{aktivitas}', [AktivitasController::class, 'destroy'])->name('aktivitas.destroy');
    });
});
