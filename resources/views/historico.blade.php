@extends('layouts.zeigarnik')

@section('title', 'Histórico · Zeigarnik')

@section('content')
    <div class="flex items-center justify-between mt-2 mb-1">
        <h1 class="text-[22px] font-bold">Histórico</h1>
        <a href="{{ route('historico.exportar') }}" class="text-xs text-[#6B7A5E] font-medium">Exportar semana</a>
    </div>
    <div class="flex items-center gap-1.5 bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] text-[var(--accent-soft-text)] px-3 py-2 rounded-xl w-fit mb-6 text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 stroke-[var(--accent-soft-text)]" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>
        </svg>
        {{ $streak }} {{ $streak === 1 ? 'dia' : 'dias' }} seguidos
    </div>

    @forelse ($entriesPorDia as $data => $entries)
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-2 px-1">
                <h2 class="text-xs font-semibold text-[var(--text-muted)] uppercase tracking-wide">{{ \Carbon\Carbon::parse($data)->translatedFormat('d \d\e F') }}</h2>
                @if (isset($rituais[$data]) && $rituais[$data]->humor_saida)
                    <span class="text-xs text-[var(--text-faint)]">· humor {{ $rituais[$data]->humor_saida }}/5</span>
                @endif
            </div>
            <ul class="space-y-2">
                @foreach ($entries as $entry)
                    <li class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-3">
                        <p class="font-semibold text-[15px] mb-1">{{ $entry->task->title }}</p>
                        <p class="text-xs text-[var(--text-faint)]">{{ $entry->onde_parei }}</p>
                        <p class="text-xs text-[#6B7A5E] mt-1 font-medium">→ {{ $entry->proxima_acao }}</p>
                        @if ($entry->bloqueios)
                            <p class="text-xs text-[var(--danger-text)] mt-1">Bloqueio: {{ $entry->bloqueios }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-[var(--text-faint)] text-sm py-4 text-center">Nenhum loop fechado ainda.</p>
    @endforelse
@endsection
