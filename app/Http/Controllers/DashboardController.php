<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tasksAbertas = Task::abertas()->latest()->get();
        $tasksEncerradas = Task::where('status', 'encerrada')->latest()->take(10)->get();

        $inicioSemana = today()->startOfWeek();
        $fimSemana = today()->endOfWeek();

        $rituaisSemana = \App\Models\DailyRitual::whereBetween('date', [$inicioSemana, $fimSemana])
            ->whereNotNull('finished_at')
            ->get();

        $mediaHumor = $rituaisSemana->avg('humor_saida');
        $tarefasFechadasSemana = \App\Models\LoopEntry::whereBetween('date', [$inicioSemana, $fimSemana])
            ->whereHas('task', fn ($q) => $q->where('status', 'encerrada'))
            ->count();

        $compromissosHoje = \App\Models\Appointment::doDia(today())->orderBy('time_start')->get();

        return view('dashboard', [
            'tasksAbertas' => $tasksAbertas,
            'tasksEncerradas' => $tasksEncerradas,
            'mediaHumor' => $mediaHumor,
            'rituaisSemanaCount' => $rituaisSemana->count(),
            'tarefasFechadasSemana' => $tarefasFechadasSemana,
            'compromissosHoje' => $compromissosHoje,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:chamado,codigo,outro',
            'tags' => 'nullable|string|max:255',
        ]);

        Task::create($data);

        return redirect()->route('dashboard')->with('status', 'Tarefa adicionada.');
    }
}
