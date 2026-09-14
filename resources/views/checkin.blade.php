@extends('layouts.zeigarnik')

@section('title', 'Check-in · Zeigarnik')

@section('content')
    <h1 class="text-2xl font-bold mb-1">Check-in Matinal</h1>
    <p class="text-[#8A8171] text-sm mb-8">O plano que você deixou ontem.</p>

    @if ($ritualOntem)
        <div class="mb-6 text-sm text-[#8A8171]">
            Humor de saída ontem:
            <span class="font-medium text-[#2A2722]">{{ $ritualOntem->humor_saida ? $ritualOntem->humor_saida . '/5' : '—' }}</span>
            @if ($ritualOntem->observacoes)
                <p class="mt-1 italic">"{{ $ritualOntem->observacoes }}"</p>
            @endif
        </div>
    @endif

    <ul class="space-y-3">
        @forelse ($entriesOntem as $entry)
            <li class="bg-white border border-[#DDD5C7] rounded-lg px-4 py-3">
                <p class="font-medium mb-2">{{ $entry->task->title }}</p>
                <p class="text-xs text-[#A79E8C] mb-1">Onde parou:</p>
                <p class="text-sm text-[#2A2722] mb-2">{{ $entry->onde_parei }}</p>
                <p class="text-xs text-[#A79E8C] mb-1">Primeira ação de hoje:</p>
                <p class="text-sm text-[#5C6A50]">{{ $entry->proxima_acao }}</p>
            </li>
        @empty
            <li class="text-[#A79E8C] text-sm">Nenhum registro de ontem.</li>
        @endforelse
    </ul>
@endsection
