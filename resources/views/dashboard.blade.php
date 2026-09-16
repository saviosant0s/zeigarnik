@extends('layouts.zeigarnik')

@section('title', 'Dashboard · Zeigarnik')

@section('content')
    <h1 class="text-[22px] font-bold mb-1 mt-2">Dashboard</h1>
    <p class="text-[var(--text-muted)] text-sm mb-4">Loops abertos hoje.</p>

    <div class="grid grid-cols-3 gap-2 mb-6">
        <div class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-3 py-3 text-center">
            <p class="text-lg font-bold">{{ $mediaHumor ? number_format($mediaHumor, 1) : '—' }}</p>
            <p class="text-[10px] text-[var(--text-muted)] uppercase tracking-wide mt-0.5">Humor médio</p>
        </div>
        <div class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-3 py-3 text-center">
            <p class="text-lg font-bold">{{ $rituaisSemanaCount }}</p>
            <p class="text-[10px] text-[var(--text-muted)] uppercase tracking-wide mt-0.5">Rituais na semana</p>
        </div>
        <div class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-3 py-3 text-center">
            <p class="text-lg font-bold">{{ $tarefasFechadasSemana }}</p>
            <p class="text-[10px] text-[var(--text-muted)] uppercase tracking-wide mt-0.5">Fechadas na semana</p>
        </div>
    </div>

    @if ($compromissosHoje->isNotEmpty())
        <h2 class="text-xs font-semibold text-[var(--text-muted)] mb-3 uppercase tracking-wide">Compromissos de hoje</h2>
        <ul class="space-y-2 mb-8">
            @foreach ($compromissosHoje as $c)
                <li class="flex items-center gap-3 bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-3 {{ $c->done ? 'opacity-50' : '' }}">
                    <span class="text-sm font-mono text-[var(--accent)] w-12 shrink-0">{{ $c->time_start ? \Carbon\Carbon::parse($c->time_start)->format('H:i') : '—' }}</span>
                    <span class="text-[15px] {{ $c->done ? 'line-through' : '' }}">{{ $c->title }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST" class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 mb-8 space-y-3">
        @csrf
        <input type="text" name="title" placeholder="Nova tarefa..." required
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
        <div class="flex gap-2">
            <input type="text" name="tags" placeholder="tags (opcional)"
                class="flex-1 bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
            <select name="type" class="bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
                <option value="chamado">Chamado</option>
                <option value="codigo">Código</option>
                <option value="outro" selected>Outro</option>
            </select>
        </div>
        <button class="w-full bg-[var(--accent)] active:bg-[var(--accent-hover)] text-white dark:text-[#0F0F10] rounded-xl py-3.5 text-[15px] font-semibold">
            Adicionar tarefa
        </button>
    </form>

    <h2 class="text-xs font-semibold text-[var(--text-muted)] mb-3 uppercase tracking-wide">Abertas ({{ $tasksAbertas->count() }})</h2>
    <ul class="space-y-2 mb-10">
        @forelse ($tasksAbertas as $task)
            <li>
                <a href="{{ route('ritual.form', $task) }}" class="flex items-center justify-between bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-4 active:bg-[var(--bg)]">
                    <div class="min-w-0">
                        <p class="font-medium text-[15px] truncate">{{ $task->title }}</p>
                        <p class="text-xs text-[var(--text-faint)] mt-0.5 uppercase">
                            {{ $task->type }}
                            @if ($task->tags)
                                <span class="text-[var(--accent)] normal-case">· #{{ str_replace(',', ' #', $task->tags) }}</span>
                            @endif
                        </p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 ml-2" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </li>
        @empty
            <li class="text-[var(--text-faint)] text-sm py-4 text-center">Nenhuma tarefa aberta.</li>
        @endforelse
    </ul>

    <h2 class="text-xs font-semibold text-[var(--text-muted)] mb-3 uppercase tracking-wide">Encerradas recentemente</h2>
    <ul class="space-y-1">
        @foreach ($tasksEncerradas as $task)
            <li class="text-sm text-[var(--text-faint)] line-through px-1">{{ $task->title }}</li>
        @endforeach
    </ul>
@endsection
