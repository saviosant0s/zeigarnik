@extends('layouts.zeigarnik')

@section('title', 'Histórico · Zeigarnik')

@section('content')
    <div class="flex items-center justify-between mb-1">
        <h1 class="text-2xl font-bold">Histórico</h1>
        <span class="text-sm bg-[#EAF0E4] border border-[#B9C9A9] text-[#4C5A3E] px-3 py-1 rounded-lg flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="#4C5A3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/>
            </svg>
            {{ $streak }} {{ $streak === 1 ? 'dia' : 'dias' }} seguidos
        </span>
    </div>
    <p class="text-[#8A8171] text-sm mb-8">Loops fechados por dia.</p>

    @forelse ($entriesPorDia as $data => $entries)
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-3">
                <h2 class="text-sm font-semibold text-[#2A2722]">{{ \Carbon\Carbon::parse($data)->translatedFormat('d \d\e F, Y') }}</h2>
                @if (isset($rituais[$data]) && $rituais[$data]->humor_saida)
                    <span class="text-xs text-[#8A8171]">humor {{ $rituais[$data]->humor_saida }}/5</span>
                @endif
            </div>
            <ul class="space-y-2">
                @foreach ($entries as $entry)
                    <li class="bg-white border border-[#DDD5C7] rounded-lg px-4 py-3">
                        <p class="font-medium text-sm mb-1">{{ $entry->task->title }}</p>
                        <p class="text-xs text-[#A79E8C] mb-1">Onde parou: {{ $entry->onde_parei }}</p>
                        <p class="text-xs text-[#6B7A5E]">Próxima ação: {{ $entry->proxima_acao }}</p>
                        @if ($entry->bloqueios)
                            <p class="text-xs text-[#8A4A4A] mt-1">Bloqueio: {{ $entry->bloqueios }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-[#A79E8C] text-sm">Nenhum loop fechado ainda.</p>
    @endforelse
@endsection
