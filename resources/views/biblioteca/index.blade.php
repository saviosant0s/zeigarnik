@extends('layouts.zeigarnik')

@section('title', 'Biblioteca · Zeigarnik')

@section('content')
    <h1 class="text-[22px] font-bold mb-1 mt-2">Biblioteca</h1>
    <p class="text-[var(--text-muted)] text-sm mb-6">Entenda a psicologia por trás do sistema.</p>

    <div class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 mb-6">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium">Progresso</span>
            <span class="text-sm text-[var(--text-muted)]">{{ $totalLidos }}/{{ $totalArtigos }} lidos</span>
        </div>
        <div class="h-2 rounded-full bg-[var(--bg)] overflow-hidden">
            <div class="h-full rounded-full bg-[var(--accent)]" style="width: {{ $totalArtigos > 0 ? ($totalLidos / $totalArtigos) * 100 : 0 }}%"></div>
        </div>
    </div>

    <ul class="space-y-2">
        @foreach ($artigos as $artigo)
            <li>
                <a href="{{ route('biblioteca.show', $artigo['slug']) }}"
                   class="flex items-center gap-3 bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-4 active:bg-[var(--bg)]">
                    <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center shrink-0"
                        style="border-color: var(--accent); background: {{ $artigo['lido'] ? 'var(--accent)' : 'transparent' }};">
                        @if ($artigo['lido'])
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-white dark:text-[#0F0F10]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>
                        @endif
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-[15px] {{ $artigo['lido'] ? 'text-[var(--text-muted)]' : '' }}">{{ $artigo['titulo'] }}</p>
                        <p class="text-xs text-[var(--text-faint)] mt-0.5">{{ $artigo['tempo'] }} min de leitura</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[var(--text-faint)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </a>
            </li>
        @endforeach
    </ul>
@endsection
