@extends('layouts.zeigarnik')

@section('title', 'Dashboard · Zeigarnik')

@section('content')
    <h1 class="text-2xl font-bold mb-1">Dashboard</h1>
    <p class="text-[#8A8171] text-sm mb-8">Loops abertos hoje.</p>

    <form action="{{ route('tasks.store') }}" method="POST" class="flex gap-2 mb-8">
        @csrf
        <input type="text" name="title" placeholder="Nova tarefa..." required
            class="flex-1 bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#6B7A5E]">
        <input type="text" name="tags" placeholder="tags (opcional)"
            class="w-40 bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#6B7A5E]">
        <select name="type" class="bg-white border border-[#DDD5C7] rounded-lg px-3 py-2 text-sm">
            <option value="chamado">Chamado</option>
            <option value="codigo">Código</option>
            <option value="outro" selected>Outro</option>
        </select>
        <button class="bg-[#6B7A5E] hover:bg-[#5C6A50] text-white rounded-lg px-4 py-2 text-sm font-medium">Adicionar</button>
    </form>

    <h2 class="text-sm font-semibold text-[#8A8171] mb-3 uppercase tracking-wide">Abertas ({{ $tasksAbertas->count() }})</h2>
    <ul class="space-y-2 mb-10">
        @forelse ($tasksAbertas as $task)
            <li class="flex items-center justify-between bg-white border border-[#DDD5C7] rounded-lg px-4 py-3">
                <div>
                    <span class="font-medium">{{ $task->title }}</span>
                    <span class="text-xs text-[#A79E8C] ml-2 uppercase">{{ $task->type }}</span>
                    @if ($task->tags)
                        <span class="text-xs text-[#6B7A5E] ml-2">#{{ str_replace(',', ' #', $task->tags) }}</span>
                    @endif
                </div>
                <a href="{{ route('ritual.form', $task) }}" class="text-xs text-[#6B7A5E] hover:text-[#5C6A50]">Fechar loop →</a>
            </li>
        @empty
            <li class="text-[#A79E8C] text-sm">Nenhuma tarefa aberta.</li>
        @endforelse
    </ul>

    <h2 class="text-sm font-semibold text-[#A79E8C] mb-3 uppercase tracking-wide">Encerradas recentemente</h2>
    <ul class="space-y-1">
        @foreach ($tasksEncerradas as $task)
            <li class="text-sm text-[#A79E8C] line-through">{{ $task->title }}</li>
        @endforeach
    </ul>
@endsection
