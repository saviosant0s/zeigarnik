@extends('layouts.zeigarnik')

@section('title', 'Importar agenda · Zeigarnik')

@section('content')
    <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        voltar
    </a>
    <h1 class="text-[20px] font-bold mb-2">Importar agenda</h1>
    <p class="text-sm text-[var(--text-muted)] mb-6">Envie um arquivo .ics exportado do Google Calendar, Outlook, etc.</p>

    <form action="{{ route('appointments.importar') }}" method="POST" enctype="multipart/form-data"
          class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 space-y-4">
        @csrf
        <input type="file" name="arquivo" accept=".ics" required
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        <button class="w-full bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl py-3.5 text-[15px] font-semibold">
            Importar
        </button>
    </form>
@endsection
