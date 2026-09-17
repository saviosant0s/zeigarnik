@extends('layouts.zeigarnik')

@section('title', 'O Efeito na Prática · Zeigarnik')

@section('content')
    <a href="{{ route('biblioteca.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Biblioteca
    </a>
    <p class="text-xs text-[var(--text-faint)] mb-1">{{ $meta['tempo'] }} min de leitura</p>
    <h1 class="text-[22px] font-bold mb-6">O Efeito na Prática</h1>

    <div class="space-y-4 text-[15px] leading-relaxed text-[var(--text)]">
        <p>
            Por que exatamente o cérebro insiste em voltar pra uma tarefa que você nem está fazendo
            no momento? A resposta tem a ver com como a <strong>memória de trabalho</strong> funciona.
        </p>

        <p>
            Enquanto uma tarefa está marcada como "em aberto", uma parte da sua atenção fica alocada
            nela — mesmo em segundo plano. É por isso que, à noite, tarefas inacabadas do trabalho
            aparecem na sua cabeça bem na hora de dormir: a memória de trabalho está sobrecarregada
            de "processos abertos" que o cérebro não conseguiu encerrar.
        </p>

        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 my-6">
            <p class="text-sm text-[var(--accent-soft-text)] italic">
                Pensamentos intrusivos antes de dormir não são "falta de disciplina" — muitas vezes
                são só o Efeito Zeigarnik fazendo seu trabalho de manter loops abertos ativos.
            </p>
        </div>

        <p>
            Esse mesmo mecanismo é usado (de propósito) em vários lugares fora da psicologia clínica:
        </p>

        <ul class="list-disc pl-5 space-y-2">
            <li><strong>Cliffhangers em séries</strong> — terminar um episódio no meio de uma cena tensa mantém você "preso" até o próximo.</li>
            <li><strong>Textos que "prendem"</strong> — abrir uma pergunta ou situação sem responder de imediato faz o leitor continuar.</li>
            <li><strong>Publicidade</strong> — anúncios que deixam uma informação incompleta te fazem querer buscar o resto.</li>
        </ul>

        <p>
            O problema é quando isso acontece sem controle, com as próprias tarefas do seu dia. Você
            não decide conscientemente ficar pensando no chamado que não terminou — isso simplesmente
            acontece, drenando foco e atrapalhando o descanso.
        </p>
    </div>

    @include('biblioteca._nav')
@endsection
