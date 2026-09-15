@extends('layouts.zeigarnik')

@section('title', 'Agenda · Zeigarnik')

@section('content')
    <div class="flex items-center justify-between mt-2 mb-4">
        <h1 class="text-[22px] font-bold">Agenda</h1>
        <a href="{{ route('appointments.create') }}" class="bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl px-3 py-2 text-sm font-medium">
            + Novo
        </a>
    </div>

    <div class="flex gap-2 mb-4 text-xs">
        <a href="{{ route('appointments.exportar') }}" class="text-[#6B7A5E] font-medium">Exportar .ics</a>
        <span class="text-[var(--text-faint)]">·</span>
        <a href="{{ route('appointments.importar.form') }}" class="text-[#6B7A5E] font-medium">Importar .ics</a>
    </div>

    <div class="flex items-center justify-between mb-3 bg-[var(--surface)] border border-[var(--border)] rounded-xl px-2 py-2">
        <a href="{{ route('appointments.index', ['semana' => $inicio->copy()->subWeek()->toDateString(), 'tipo' => $tipoAtivo]) }}"
           class="w-9 h-9 flex items-center justify-center text-[var(--text-muted)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <span class="text-sm font-medium">{{ $inicio->translatedFormat('d \d\e M') }} – {{ $fim->translatedFormat('d \d\e M') }}</span>
        <a href="{{ route('appointments.index', ['semana' => $inicio->copy()->addWeek()->toDateString(), 'tipo' => $tipoAtivo]) }}"
           class="w-9 h-9 flex items-center justify-center text-[var(--text-muted)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    </div>

    @php
        $tipos = ['reuniao' => 'Reunião', 'prazo' => 'Prazo', 'chamada' => 'Chamada', 'outro' => 'Outro'];
        $tipoCor = ['reuniao' => '#6B90A6', 'prazo' => '#B4674A', 'chamada' => '#6B7A5E', 'outro' => '#8A8171'];
    @endphp

    <div class="flex gap-1.5 mb-5 overflow-x-auto pb-1">
        <a href="{{ route('appointments.index', ['semana' => $inicio->toDateString()]) }}"
           class="shrink-0 text-xs px-3 py-1.5 rounded-full {{ ! $tipoAtivo ? 'bg-[#2A2722] text-white' : 'bg-[var(--surface)] border border-[var(--border)] text-[var(--text-muted)]' }}">
            Todos
        </a>
        @foreach ($tipos as $val => $label)
            <a href="{{ route('appointments.index', ['semana' => $inicio->toDateString(), 'tipo' => $val]) }}"
               class="shrink-0 text-xs px-3 py-1.5 rounded-full flex items-center gap-1.5 {{ $tipoAtivo === $val ? 'bg-[#2A2722] text-white' : 'bg-[var(--surface)] border border-[var(--border)] text-[var(--text-muted)]' }}">
                <span class="w-2 h-2 rounded-full" style="background: {{ $tipoCor[$val] }}"></span>
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="space-y-4" x-data="{
        arrastando: null,
        onDrop(dataDestino) {
            if (!this.arrastando) return;
            fetch(`/agenda/${this.arrastando}/mover`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content || '{{ csrf_token() }}' },
                body: JSON.stringify({ date: dataDestino })
            }).then(() => window.location.reload());
        }
    }">
        @foreach ($dias as $dia)
            @php $itens = $appointments->get($dia->toDateString(), collect()); @endphp
            <div
                @dragover.prevent
                @drop.prevent="onDrop('{{ $dia->toDateString() }}')"
                class="rounded-2xl">
                <div class="flex items-center gap-2 mb-2 px-1">
                    <h2 class="text-xs font-semibold uppercase tracking-wide {{ $dia->isToday() ? 'text-[#6B7A5E]' : 'text-[var(--text-muted)]' }}">
                        {{ $dia->translatedFormat('D, d/m') }}
                    </h2>
                    @if ($dia->isToday())
                        <span class="text-[10px] bg-[var(--accent-soft-bg)] text-[var(--accent-soft-text)] px-2 py-0.5 rounded-full">hoje</span>
                    @endif
                </div>

                @forelse ($itens as $item)
                    <div draggable="true"
                         @dragstart="arrastando = {{ $item->id }}"
                         class="flex items-start gap-3 bg-[var(--surface)] border rounded-2xl px-4 py-3 mb-2 cursor-grab active:cursor-grabbing {{ $item->done ? 'opacity-50' : '' }} {{ isset($conflitos[$item->id]) ? 'border-[var(--danger-text)]' : 'border-[var(--border)]' }}">
                        <span class="w-1.5 self-stretch rounded-full shrink-0" style="background: {{ $tipoCor[$item->type] }}"></span>
                        <form action="{{ route('appointments.toggle', $item) }}" method="POST" class="mt-0.5">
                            @csrf
                            <button type="submit" class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                                style="border-color: {{ $tipoCor[$item->type] }}; background: {{ $item->done ? $tipoCor[$item->type] : 'transparent' }};">
                                @if ($item->done)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>
                                @endif
                            </button>
                        </form>
                        <a href="{{ route('appointments.edit', $item) }}" class="flex-1 min-w-0">
                            <p class="font-medium text-[15px] {{ $item->done ? 'line-through' : '' }}">{{ $item->title }}</p>
                            <p class="text-xs text-[var(--text-muted)] mt-0.5">
                                @if ($item->time_start)
                                    {{ \Carbon\Carbon::parse($item->time_start)->format('H:i') }}
                                    @if ($item->time_end) – {{ \Carbon\Carbon::parse($item->time_end)->format('H:i') }} @endif
                                @endif
                                @if ($item->location) · {{ $item->location }} @endif
                                @if (isset($conflitos[$item->id]))
                                    <span class="text-[var(--danger-text)] font-medium">· conflito de horário</span>
                                @endif
                            </p>
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-[var(--text-faint)] px-1 pb-2">—</p>
                @endforelse
            </div>
        @endforeach
    </div>
@endsection
