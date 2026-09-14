@extends('layouts.zeigarnik')

@section('title', 'Encerrar · ' . $task->title)

@section('content')
    <a href="{{ route('ritual.index') }}" class="inline-flex items-center gap-1 text-xs text-[#A79E8C] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        voltar
    </a>
    <h1 class="text-[20px] font-bold mb-6">{{ $task->title }}</h1>

    <form action="{{ route('ritual.save', $task) }}" method="POST" class="bg-white border border-[#DDD5C7] rounded-2xl p-4 space-y-4">
        @csrf
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Onde eu parei</label>
            <textarea name="onde_parei" required rows="3"
                class="w-full bg-[#F4F0E8] border border-[#DDD5C7] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[#6B7A5E]">{{ old('onde_parei', $entry->onde_parei ?? '') }}</textarea>
        </div>
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Primeira ação de amanhã</label>
            <textarea name="proxima_acao" required rows="3"
                class="w-full bg-[#F4F0E8] border border-[#DDD5C7] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[#6B7A5E]">{{ old('proxima_acao', $entry->proxima_acao ?? '') }}</textarea>
        </div>
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Bloqueios (o que impediu avançar)</label>
            <textarea name="bloqueios" rows="2"
                class="w-full bg-[#F4F0E8] border border-[#DDD5C7] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[#6B7A5E]">{{ old('bloqueios', $entry->bloqueios ?? '') }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-[#8A8171] py-1">
            <input type="checkbox" name="fechar_tarefa" value="1" class="w-5 h-5 rounded bg-[#F4F0E8] border-[#DDD5C7]">
            Marcar tarefa como encerrada
        </label>
        <button class="w-full bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl py-3.5 text-[15px] font-semibold">
            Salvar loop
        </button>
    </form>
@endsection
