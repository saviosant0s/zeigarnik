@extends('layouts.zeigarnik')

@section('title', 'Dashboard · Zeigarnik')

@section('content')
    <h1 class="text-2xl font-bold mb-1">Dashboard</h1>
    <p class="text-slate-400 text-sm mb-8">Loops abertos hoje.</p>

    <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-8">
        @csrf
        <input type="text" name="title" placeholder="Nova tarefa..." required
            class="flex-1 bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-slate-600">
        <select name="type" class="bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm">
            <option value="chamado">Chamado</option>
            <option value="codigo">Código</option>
            <option value="outro" selected>Outro</option>
        </select>
        <button class="bg-emerald-700 hover:bg-emerald-600 rounded-lg px-4 py-2 text-sm font-medium">Adicionar</button>
    </form>

    <h2 class="text-sm font-semibold text-slate-400 mb-3 uppercase tracking-wide">Abertas ({{ $tasksAbertas->count() }})</h2>
    <ul class="space-y-2 mb-10">
        @forelse ($tasksAbertas as $task)
            <li class="flex items-center justify-between bg-slate-900 border border-slate-800 rounded-lg px-4 py-3">
                <div>
                    <span class="font-medium">{{ $task->title }}</span>
                    <span class="text-xs text-slate-500 ml-2 uppercase">{{ $task->type }}</span>
                </div>
                <a href="{{ route('ritual.form', $task) }}" class="text-xs text-emerald-400 hover:text-emerald-300">Fechar loop →</a>
            </li>
        @empty
            <li class="text-slate-500 text-sm">Nenhuma tarefa aberta. 🎉</li>
        @endforelse
    </ul>

    <h2 class="text-sm font-semibold text-slate-500 mb-3 uppercase tracking-wide">Encerradas recentemente</h2>
    <ul class="space-y-1">
        @foreach ($tasksEncerradas as $task)
            <li class="text-sm text-slate-500 line-through">{{ $task->title }}</li>
        @endforeach
    </ul>
@endsection
