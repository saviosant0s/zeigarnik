@extends('layouts.zeigarnik')

@section('title', 'Novo compromisso · Zeigarnik')

@section('content')
    <a href="{{ route('appointments.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        voltar
    </a>
    <h1 class="text-[20px] font-bold mb-6">Novo compromisso</h1>

    <form action="{{ route('appointments.store') }}" method="POST" class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 space-y-4">
        @csrf
        @include('appointments._form')
        <button class="w-full bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl py-3.5 text-[15px] font-semibold">
            Salvar compromisso
        </button>
    </form>
@endsection
