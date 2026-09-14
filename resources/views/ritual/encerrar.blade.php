@extends('layouts.zeigarnik')

@section('title', 'Encerrar · ' . $task->title)

@section('content')
    <a href="{{ route('ritual.index') }}" class="text-xs text-[#A79E8C] hover:text-[#2A2722]">← voltar</a>
    <h1 class="text-2xl font-bold mt-2 mb-8">{{ $task->title }}</h1>

    <form action="{{ route('ritual.save', $task) }}" method="POST" class="space-y-5">
        @csrf
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Onde eu parei</label>
            <textarea name="onde_parei" required rows="3"
                class="w-full bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#6B7A5E]">{{ old('onde_parei', $entry->onde_parei ?? '') }}</textarea>
        </div>
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Primeira ação de amanhã</label>
            <textarea name="proxima_acao" required rows="3"
                class="w-full bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#6B7A5E]">{{ old('proxima_acao', $entry->proxima_acao ?? '') }}</textarea>
        </div>
        <div>
            <label class="text-sm text-[#8A8171] block mb-2">Bloqueios (o que impediu avançar)</label>
            <textarea name="bloqueios" rows="2"
                class="w-full bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#6B7A5E]">{{ old('bloqueios', $entry->bloqueios ?? '') }}</textarea>
        </div>
        <label class="flex items-center gap-2 text-sm text-[#8A8171]">
            <input type="checkbox" name="fechar_tarefa" value="1" class="rounded bg-white border-[#DDD5C7]">
            Marcar tarefa como encerrada (concluída de vez)
        </label>
        <button class="bg-[#6B7A5E] hover:bg-[#5C6A50] text-white rounded-lg px-5 py-2.5 text-sm font-medium">Salvar loop</button>
    </form>
@endsection
