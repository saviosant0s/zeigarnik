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

        return view('dashboard', [
            'tasksAbertas' => $tasksAbertas,
            'tasksEncerradas' => $tasksEncerradas,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:chamado,codigo,outro',
        ]);

        Task::create($data);

        return redirect()->route('dashboard')->with('status', 'Tarefa adicionada.');
    }
}
