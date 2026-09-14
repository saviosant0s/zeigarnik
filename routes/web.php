<?php

use App\Http\Controllers\CheckinController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\RitualController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/tasks', [DashboardController::class, 'store'])->name('tasks.store');

Route::get('/ritual', [RitualController::class, 'index'])->name('ritual.index');
Route::get('/ritual/{task}', [RitualController::class, 'form'])->name('ritual.form');
Route::post('/ritual/{task}', [RitualController::class, 'save'])->name('ritual.save');
Route::post('/ritual-finish', [RitualController::class, 'finish'])->name('ritual.finish');

Route::get('/checkin', [CheckinController::class, 'index'])->name('checkin');
Route::get('/historico', [HistoricoController::class, 'index'])->name('historico');
