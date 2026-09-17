@extends('layouts.zeigarnik')

@section('title', 'Quem foi Bluma Zeigarnik · Zeigarnik')

@section('content')
    <a href="{{ route('biblioteca.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Biblioteca
    </a>
    <p class="text-xs text-[var(--text-faint)] mb-1">{{ $meta['tempo'] }} min de leitura</p>
    <h1 class="text-[22px] font-bold mb-6">Quem foi Bluma Zeigarnik</h1>

    <div class="space-y-4 text-[15px] leading-relaxed text-[var(--text)]">
        <p>
            Bluma Wulfovna Zeigarnik nasceu em 1901 na Lituânia, então parte do Império Russo.
            Numa época em que poucas mulheres tinham acesso à universidade, ela seguiu para Berlim
            estudar psicologia — e foi lá que sua carreira mudou de rumo.
        </p>

        <p>
            Em Berlim, Bluma se tornou aluna de <strong>Kurt Lewin</strong>, um dos nomes centrais da
            psicologia social do século 20 e pioneiro no estudo da motivação e do comportamento humano
            dentro de contextos concretos do dia a dia.
        </p>

        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 my-6">
            <p class="text-sm text-[var(--accent-soft-text)] italic">
                A ideia do experimento que levaria seu nome surgiu, segundo relatos, numa conversa
                informal num café — Lewin havia notado algo curioso no comportamento dos garçons do
                local, e sugeriu que Bluma investigasse cientificamente.
            </p>
        </div>

        <p>
            Depois de formalizar e publicar o estudo em 1927 (você vai ler sobre ele no próximo
            artigo), Bluma voltou para a União Soviética, onde construiu o restante da carreira
            trabalhando principalmente com <strong>psiquiatria e neuropsicologia clínica</strong>,
            longe do ambiente acadêmico ocidental que a havia formado.
        </p>

        <p>
            Ela faleceu em 1988, mas o efeito que leva seu nome sobreviveu décadas e hoje aparece em
            áreas que vão da psicologia cognitiva ao design de produtos, storytelling e — como você
            está vendo agora — ferramentas de produtividade pessoal.
        </p>
    </div>

    @include('biblioteca._nav')
@endsection
