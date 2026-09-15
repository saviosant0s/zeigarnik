@extends('layouts.zeigarnik')

@section('title', 'Mês · Zeigarnik')

@section('content')
    <div class="flex items-center justify-between mt-2 mb-1">
        <h1 class="text-[22px] font-bold">{{ $mesReferencia->translatedFormat('F \d\e Y') }}</h1>
        <a href="{{ route('appointments.index') }}" class="text-xs text-[#6B7A5E] font-medium">Ver semana</a>
    </div>
    <p class="text-sm text-[var(--text-muted)] mb-4">{{ $totalMes }} {{ $totalMes === 1 ? 'compromisso' : 'compromissos' }} este mês.</p>

    <div class="flex items-center justify-between mb-4 bg-[var(--surface)] border border-[var(--border)] rounded-xl px-2 py-2">
        <a href="{{ route('appointments.mensal', ['mes' => $mesReferencia->copy()->subMonth()->format('Y-m'), 'tipo' => $tipoAtivo]) }}"
           class="w-9 h-9 flex items-center justify-center text-[var(--text-muted)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <span class="text-sm font-medium">{{ $mesReferencia->translatedFormat('F Y') }}</span>
        <a href="{{ route('appointments.mensal', ['mes' => $mesReferencia->copy()->addMonth()->format('Y-m'), 'tipo' => $tipoAtivo]) }}"
           class="w-9 h-9 flex items-center justify-center text-[var(--text-muted)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    </div>

    @php
        $tipos = ['reuniao' => 'Reunião', 'prazo' => 'Prazo', 'chamada' => 'Chamada', 'outro' => 'Outro'];
        $tipoCor = ['reuniao' => '#6B90A6', 'prazo' => '#B4674A', 'chamada' => '#6B7A5E', 'outro' => '#8A8171'];
    @endphp

    <div class="flex gap-1.5 mb-5 overflow-x-auto pb-1">
        <a href="{{ route('appointments.mensal', ['mes' => $mesReferencia->format('Y-m')]) }}"
           class="shrink-0 text-xs px-3 py-1.5 rounded-full {{ ! $tipoAtivo ? 'bg-[#2A2722] text-white' : 'bg-[var(--surface)] border border-[var(--border)] text-[var(--text-muted)]' }}">
            Todos
        </a>
        @foreach ($tipos as $val => $label)
            <a href="{{ route('appointments.mensal', ['mes' => $mesReferencia->format('Y-m'), 'tipo' => $val]) }}"
               class="shrink-0 text-xs px-3 py-1.5 rounded-full flex items-center gap-1.5 {{ $tipoAtivo === $val ? 'bg-[#2A2722] text-white' : 'bg-[var(--surface)] border border-[var(--border)] text-[var(--text-muted)]' }}">
                <span class="w-2 h-2 rounded-full" style="background: {{ $tipoCor[$val] }}"></span>
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-1 mb-1">
        @foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $letra)
            <div class="text-center text-[10px] font-semibold text-[var(--text-faint)] uppercase py-1">{{ $letra }}</div>
        @endforeach
    </div>

    <div class="grid grid-cols-7 gap-1">
        @foreach ($semanas as $semana)
            @foreach ($semana as $dia)
                @php
                    $itens = $porDia->get($dia->toDateString(), collect());
                    $foraDoMes = ! $dia->isSameMonth($mesReferencia);
                @endphp
                <a href="{{ route('appointments.index', ['semana' => $dia->toDateString(), 'tipo' => $tipoAtivo]) }}"
                   class="aspect-square rounded-xl border flex flex-col items-center justify-center gap-0.5 relative
                          {{ $dia->isToday() ? 'border-[#6B7A5E] bg-[var(--accent-soft-bg)]' : 'border-[var(--border)] bg-[var(--surface)]' }}
                          {{ $foraDoMes ? 'opacity-30' : '' }}">
                    <span class="text-xs font-medium {{ $dia->isToday() ? 'text-[#6B7A5E] font-bold' : '' }}">{{ $dia->day }}</span>
                    @if ($itens->isNotEmpty())
                        <div class="flex gap-0.5">
                            @foreach ($itens->take(3) as $item)
                                <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $tipoCor[$item->type] }}"></span>
                            @endforeach
                            @if ($itens->count() > 3)
                                <span class="text-[8px] text-[var(--text-faint)]">+</span>
                            @endif
                        </div>
                    @endif
                </a>
            @endforeach
        @endforeach
    </div>
@endsection
