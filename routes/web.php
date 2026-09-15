<?php

use App\Http\Controllers\AppointmentController;
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
Route::get('/historico/exportar', [HistoricoController::class, 'exportarSemana'])->name('historico.exportar');

Route::get('/agenda', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/agenda/mes', [AppointmentController::class, 'mensal'])->name('appointments.mensal');
Route::get('/agenda/novo', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/agenda', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/agenda/exportar.ics', [AppointmentController::class, 'exportarIcs'])->name('appointments.exportar');
Route::get('/agenda/importar', [AppointmentController::class, 'importarIcsForm'])->name('appointments.importar.form');
Route::post('/agenda/importar', [AppointmentController::class, 'importarIcs'])->name('appointments.importar');
Route::get('/agenda/{appointment}/editar', [AppointmentController::class, 'edit'])->name('appointments.edit');
Route::put('/agenda/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
Route::delete('/agenda/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
Route::delete('/agenda/{appointment}/serie', [AppointmentController::class, 'destroySerie'])->name('appointments.destroy-serie');
Route::post('/agenda/{appointment}/toggle', [AppointmentController::class, 'toggleDone'])->name('appointments.toggle');
Route::post('/agenda/{appointment}/mover', [AppointmentController::class, 'moverData'])->name('appointments.mover');

Route::get('/configuracoes', [\App\Http\Controllers\SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/configuracoes', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
Route::post('/configuracoes/testar', [\App\Http\Controllers\SettingsController::class, 'testar'])->name('settings.testar');

// endpoint pra disparar o cron dos lembretes via serviço externo (ex: cron-job.org, a cada minuto)
Route::get('/cron/lembretes', function () {
    \Illuminate\Support\Facades\Artisan::call('zeigarnik:lembretes');
    return response('ok');
});
