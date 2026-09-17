@extends('layouts.zeigarnik')

@section('title', 'O Experimento Original (1927) · Zeigarnik')

@section('content')
    <a href="{{ route('biblioteca.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Biblioteca
    </a>
    <p class="text-xs text-[var(--text-faint)] mb-1">{{ $meta['tempo'] }} min de leitura</p>
    <h1 class="text-[22px] font-bold mb-6">O Experimento Original (1927)</h1>

    <div class="space-y-4 text-[15px] leading-relaxed text-[var(--text)]">
        <p>
            Tudo começou com uma observação simples de Kurt Lewin: os garçons de um café em Berlim
            pareciam lembrar perfeitamente os pedidos de mesas que ainda não tinham sido pagos —
            mas, assim que a conta era fechada, esqueciam os detalhes quase instantaneamente.
        </p>

        <p>
            Bluma Zeigarnik transformou essa observação informal num experimento controlado. Ela deu
            aos participantes uma série de pequenas tarefas — quebra-cabeças, contas simples, montar
            figuras. Em algumas delas, deixava a pessoa concluir normalmente. Em outras, interrompia
            de propósito no meio, sem avisar antes que aquilo aconteceria.
        </p>

        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 my-6">
            <p class="text-sm text-[var(--accent-soft-text)] italic">
                O resultado: tarefas interrompidas eram lembradas cerca de 90% melhor do que as
                tarefas concluídas normalmente.
            </p>
        </div>

        <p>
            A explicação de Zeigarnik era que uma tarefa inacabada cria uma espécie de
            <strong>tensão psicológica</strong> — o cérebro mantém aquilo "em aberto" na memória,
            ativamente, até que exista algum tipo de fechamento. Já uma tarefa concluída pode ser
            "arquivada" e esquecida sem custo.
        </p>

        <p>
            O estudo foi publicado em 1927 com o título <em>"Das Behalten erledigter und
            unerledigter Handlungen"</em> — em tradução livre, "A retenção de ações realizadas e não
            realizadas". Décadas depois, esse achado ainda é replicado (com variações) em estudos de
            memória, motivação e produtividade.
        </p>
    </div>

    @include('biblioteca._nav')
@endsection
