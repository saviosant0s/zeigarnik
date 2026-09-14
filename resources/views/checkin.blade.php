@extends('layouts.zeigarnik')

@section('title', 'Check-in · Zeigarnik')

@section('content')
    <h1 class="text-[22px] font-bold mb-1 mt-2">Check-in Matinal</h1>
    <p class="text-[#8A8171] text-sm mb-6">O plano que você deixou ontem.</p>

    @if ($ritualOntem)
        <div class="bg-white border border-[#DDD5C7] rounded-2xl px-4 py-3 mb-4 text-sm">
            <span class="text-[#8A8171]">Humor de saída ontem: </span>
            <span class="font-semibold text-[#2A2722]">{{ $ritualOntem->humor_saida ? $ritualOntem->humor_saida . '/5' : '—' }}</span>
            @if ($ritualOntem->observacoes)
                <p class="mt-1 italic text-[#8A8171]">"{{ $ritualOntem->observacoes }}"</p>
            @endif
        </div>
    @endif

    <ul class="space-y-3">
        @forelse ($entriesOntem as $entry)
            <li class="bg-white border border-[#DDD5C7] rounded-2xl px-4 py-4">
                <p class="font-semibold text-[15px] mb-3">{{ $entry->task->title }}</p>
                <p class="text-xs text-[#A79E8C] mb-1">Onde parou</p>
                <p class="text-sm text-[#2A2722] mb-3">{{ $entry->onde_parei }}</p>
                <p class="text-xs text-[#A79E8C] mb-1">Primeira ação de hoje</p>
                <p class="text-sm text-[#6B7A5E] font-medium">{{ $entry->proxima_acao }}</p>
            </li>
        @empty
            <li class="text-[#A79E8C] text-sm py-4 text-center">Nenhum registro de ontem.</li>
        @endforelse
    </ul>
@endsection
