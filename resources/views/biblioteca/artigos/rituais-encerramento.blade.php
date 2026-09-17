@extends('layouts.zeigarnik')

@section('title', 'Por que rituais de encerramento funcionam · Zeigarnik')

@section('content')
    <a href="{{ route('biblioteca.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Biblioteca
    </a>
    <p class="text-xs text-[var(--text-faint)] mb-1">{{ $meta['tempo'] }} min de leitura</p>
    <h1 class="text-[22px] font-bold mb-6">Por que rituais de encerramento funcionam</h1>

    <div class="space-y-4 text-[15px] leading-relaxed text-[var(--text)]">
        <p>
            Se uma tarefa em aberto gera tensão cognitiva, faz sentido perguntar: dá pra "enganar" o
            cérebro fazendo ele achar que a tarefa foi concluída, mesmo sem terminá-la de fato?
        </p>

        <p>
            A resposta, segundo pesquisas posteriores ao trabalho original de Zeigarnik, é
            <strong>sim</strong> — e é exatamente esse o princípio por trás do ritual de encerramento
            deste sistema.
        </p>

        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 my-6">
            <p class="text-sm text-[var(--accent-soft-text)] italic">
                Um estudo de Masicampo &amp; Baumeister (2011) mostrou que não é preciso terminar a
                tarefa pra aliviar a tensão mental — basta fazer um <strong>plano específico</strong>
                de como e quando ela será retomada.
            </p>
        </div>

        <p>
            Isso explica por que simplesmente anotar "onde parei" e "qual a próxima ação" já reduz
            bastante aquela sensação de tarefa pairando na cabeça. O papel (ou o app) vira uma
            <strong>extensão da sua memória</strong> — o cérebro não precisa mais segurar aquilo
            sozinho, porque a informação está guardada em outro lugar, com um plano de retomada claro.
        </p>

        <p>
            E tem um segundo efeito, tão importante quanto: fazer isso num <strong>horário fixo</strong>,
            todo dia, ensina o cérebro que "esse é o momento em que a gente solta as tarefas do dia".
            Com repetição, o ritual em si vira um sinal de encerramento — parecido com um sinal de
            sono que você constrói indo pra cama sempre no mesmo horário.
        </p>

        <p>
            É por isso que o sistema não pede só uma lista de tarefas — pede especificamente
            <em>onde você parou</em> e <em>qual a primeira ação de amanhã</em>. É essa especificidade
            que faz o "fechamento cognitivo" funcionar de verdade.
        </p>
    </div>

    @include('biblioteca._nav')
@endsection
