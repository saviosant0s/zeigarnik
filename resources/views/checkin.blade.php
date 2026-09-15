@extends('layouts.zeigarnik')

@section('title', 'Check-in · Zeigarnik')

@section('content')
    <h1 class="text-[22px] font-bold mb-1 mt-2">Check-in Matinal</h1>
    <p class="text-[var(--text-muted)] text-sm mb-6">O plano que você deixou ontem.</p>

    @if ($compromissosHoje->isNotEmpty())
        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 mb-4">
            <p class="text-xs font-semibold text-[var(--accent-soft-text)] uppercase tracking-wide mb-2">Hoje você tem</p>
            <ul class="space-y-1">
                @foreach ($compromissosHoje as $c)
                    <li class="text-sm text-[var(--accent-soft-text)]">
                        <span class="font-mono">{{ $c->time_start ? \Carbon\Carbon::parse($c->time_start)->format('H:i') : '—' }}</span>
                        {{ $c->title }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($ritualOntem)
        <div class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-3 mb-4 text-sm">
            <span class="text-[var(--text-muted)]">Humor de saída ontem: </span>
            <span class="font-semibold text-[var(--text)]">{{ $ritualOntem->humor_saida ? $ritualOntem->humor_saida . '/5' : '—' }}</span>
            @if ($ritualOntem->observacoes)
                <p class="mt-1 italic text-[var(--text-muted)]">"{{ $ritualOntem->observacoes }}"</p>
            @endif
        </div>
    @endif

    <ul class="space-y-3">
        @forelse ($entriesOntem as $entry)
            <li class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-4">
                <p class="font-semibold text-[15px] mb-3">{{ $entry->task->title }}</p>
                <p class="text-xs text-[var(--text-faint)] mb-1">Onde parou</p>
                <p class="text-sm text-[var(--text)] mb-3">{{ $entry->onde_parei }}</p>
                <p class="text-xs text-[var(--text-faint)] mb-1">Primeira ação de hoje</p>
                <p class="text-sm text-[#6B7A5E] font-medium">{{ $entry->proxima_acao }}</p>
            </li>
        @empty
            <li class="text-[var(--text-faint)] text-sm py-4 text-center">Nenhum registro de ontem.</li>
        @endforelse
    </ul>
@endsection
