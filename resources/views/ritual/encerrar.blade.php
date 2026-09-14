@extends('layouts.zeigarnik')

@section('title', 'Encerrar · ' . $task->title)

@section('content')
    <a href="{{ route('ritual.index') }}" class="text-xs text-slate-500 hover:text-slate-300">← voltar</a>
    <h1 class="text-2xl font-bold mt-2 mb-8">{{ $task->title }}</h1>

    <form action="{{ route('ritual.save', $task) }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="text-sm text-slate-400 block mb-2">Onde eu parei</label>
            <textarea name="onde_parei" required rows="3"
                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-slate-600">{{ old('onde_parei', $entry->onde_parei ?? '') }}</textarea>
        </div>
        <div>
            <label class="text-sm text-slate-400 block mb-2">Primeira ação de amanhã</label>
            <textarea name="proxima_acao" required rows="3"
                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-slate-600">{{ old('proxima_acao', $entry->proxima_acao ?? '') }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-400">
            <input type="checkbox" name="fechar_tarefa" value="1" class="rounded bg-slate-900 border-slate-700">
            Marcar tarefa como encerrada (concluída de vez)
        </label>
        <button class="bg-emerald-700 hover:bg-emerald-600 rounded-lg px-5 py-2.5 text-sm font-medium">Salvar loop</button>
    </form>
@endsection
