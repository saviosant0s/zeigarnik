<?php

namespace App\Http\Controllers;

use App\Models\DailyRitual;
use App\Models\LoopEntry;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RitualController extends Controller
{
    public function index(): View
    {
        $ritual = DailyRitual::firstOrCreate(
            ['date' => today()->toDateString()],
            ['started_at' => now()]
        );

        $tasks = Task::abertas()->latest()->get();
        $compromissosAmanha = \App\Models\Appointment::doDia(today()->addDay())->orderBy('time_start')->get();

        return view('ritual.index', [
            'tasks' => $tasks,
            'ritual' => $ritual,
            'compromissosAmanha' => $compromissosAmanha,
        ]);
    }

    public function form(Task $task): View
    {
        $entry = LoopEntry::where('task_id', $task->id)
            ->where('date', today()->toDateString())
            ->first();

        return view('ritual.encerrar', [
            'task' => $task,
            'entry' => $entry,
        ]);
    }

    public function save(Request $request, Task $task): RedirectResponse
    {
        $data = $request->validate([
            'onde_parei' => 'required|string',
            'proxima_acao' => 'required|string',
            'bloqueios' => 'nullable|string',
            'fechar_tarefa' => 'nullable|boolean',
        ]);

        LoopEntry::updateOrCreate(
            ['task_id' => $task->id, 'date' => today()->toDateString()],
            [
                'onde_parei' => $data['onde_parei'],
                'proxima_acao' => $data['proxima_acao'],
                'bloqueios' => $data['bloqueios'] ?? null,
                'encerrado_em' => now(),
            ]
        );

        if ($request->boolean('fechar_tarefa')) {
            $task->update(['status' => 'encerrada']);
        }

        return redirect()->route('ritual.index')->with('status', 'Loop fechado: ' . $task->title);
    }

    public function finish(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'humor_saida' => 'nullable|integer|min:1|max:5',
            'observacoes' => 'nullable|string',
        ]);

        DailyRitual::updateOrCreate(
            ['date' => today()->toDateString()],
            array_merge($data, ['finished_at' => now()])
        );

        return redirect()->route('dashboard')->with('status', 'Ritual encerrado. Bom descanso!');
    }
}
