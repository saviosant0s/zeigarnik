@extends('layouts.zeigarnik')

@section('title', 'Ritual de Encerramento · Zeigarnik')

@section('content')
    <div x-data="{ segundos: 900 }" x-init="const t = setInterval(() => { if (segundos > 0) segundos--; else clearInterval(t) }, 1000)" class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Ritual de Encerramento</h1>
            <span class="text-lg font-mono px-3 py-1 rounded-lg"
                :class="segundos <= 60 ? 'bg-red-900/50 text-red-300' : 'bg-slate-900 text-slate-300'"
                x-text="`${String(Math.floor(segundos/60)).padStart(2,'0')}:${String(segundos%60).padStart(2,'0')}`">
            </span>
        </div>
        <p class="text-slate-400 text-sm mt-1">Feche cada loop: onde parou + próxima ação. Você tem 15 minutos.</p>
    </div>

    <ul class="space-y-2 mb-8">
        @forelse ($tasks as $task)
            <li class="flex items-center justify-between bg-slate-900 border border-slate-800 rounded-lg px-4 py-3">
                <span class="font-medium">{{ $task->title }}</span>
                <a href="{{ route('ritual.form', $task) }}" class="text-xs text-emerald-400 hover:text-emerald-300">Registrar →</a>
            </li>
        @empty
            <li class="text-slate-500 text-sm">Nenhuma tarefa aberta para encerrar.</li>
        @endforelse
    </ul>

    <form action="{{ route('ritual.finish') }}" method="POST" class="border-t border-slate-800 pt-6 space-y-4">
        @csrf
        <div>
            <label class="text-sm text-slate-400 block mb-2">Humor de saída (1–5)</label>
            <div class="flex gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="humor_saida" value="{{ $i }}" class="peer sr-only">
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-slate-900 border border-slate-800 peer-checked:bg-emerald-700 peer-checked:border-emerald-600 text-sm">{{ $i }}</span>
                    </label>
                @endfor
            </div>
        </div>
        <textarea name="observacoes" placeholder="Observações (opcional)..." rows="2"
            class="w-full bg-slate-900 border border-slate-800 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-slate-600"></textarea>
        <button class="bg-emerald-700 hover:bg-emerald-600 rounded-lg px-5 py-2.5 text-sm font-medium">Encerrar o dia</button>
    </form>
@endsection
