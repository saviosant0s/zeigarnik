@extends('layouts.zeigarnik')

@section('title', 'Editar compromisso · Zeigarnik')

@section('content')
    <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        voltar
    </a>
    <h1 class="text-[20px] font-bold mb-6">Editar compromisso</h1>

    <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 space-y-4">
        @csrf
        @method('PUT')
        @include('appointments._form', ['appointment' => $appointment])
        <label class="flex items-center gap-2 text-sm text-[var(--text-muted)] py-1">
            <input type="checkbox" name="done" value="1" {{ $appointment->done ? 'checked' : '' }} class="w-5 h-5 rounded bg-[var(--bg)] border-[var(--border)]">
            Concluído
        </label>
        <button class="w-full bg-[var(--accent)] active:bg-[var(--accent-hover)] text-white dark:text-[#0F0F10] rounded-xl py-3.5 text-[15px] font-semibold">
            Salvar alterações
        </button>
    </form>

    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="mt-3"
          onsubmit="return confirm('Remover este compromisso?')">
        @csrf
        @method('DELETE')
        <button class="w-full border border-[var(--danger-text)] text-[var(--danger-text)] rounded-xl py-3 text-sm font-medium">
            Remover compromisso
        </button>
    </form>

    @if ($appointment->recurrence_group)
        <form action="{{ route('appointments.destroy-serie', $appointment) }}" method="POST" class="mt-2"
              onsubmit="return confirm('Remover TODAS as ocorrências dessa série?')">
            @csrf
            @method('DELETE')
            <button class="w-full text-[var(--danger-text)] text-xs py-2">
                Remover série inteira
            </button>
        </form>
    @endif
@endsection
