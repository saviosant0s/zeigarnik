@extends('layouts.zeigarnik')

@section('title', 'Como usar o Sistema Zeigarnik · Zeigarnik')

@section('content')
    <a href="{{ route('biblioteca.index') }}" class="inline-flex items-center gap-1 text-xs text-[var(--text-faint)] mb-3 mt-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Biblioteca
    </a>
    <p class="text-xs text-[var(--text-faint)] mb-1">{{ $meta['tempo'] }} min de leitura</p>
    <h1 class="text-[22px] font-bold mb-6">Como usar o Sistema Zeigarnik</h1>

    <div class="space-y-4 text-[15px] leading-relaxed text-[var(--text)]">
        <p>
            Agora que você entende a ciência por trás, aqui vai o passo a passo prático de como tirar
            o máximo do sistema no dia a dia.
        </p>

        <h2 class="text-lg font-semibold mt-6 mb-2">1. Cadastre as tarefas do dia</h2>
        <p>
            No Dashboard, adicione cada coisa que você está tocando hoje — um chamado, uma parte do
            código, qualquer coisa que exija retomar de onde parou depois. Não precisa ser todo o
            trabalho, só o que está genuinamente "em aberto".
        </p>

        <h2 class="text-lg font-semibold mt-6 mb-2">2. Faça o Ritual de Encerramento</h2>
        <p>
            No fim do expediente, abra o Ritual. Pra cada tarefa aberta, escreva duas coisas com o
            máximo de especificidade possível:
        </p>
        <ul class="list-disc pl-5 space-y-1">
            <li><strong>Onde eu parei</strong> — não escreva "trabalhando no relatório", escreva "terminei a seção 2, falta revisar os números da seção 3".</li>
            <li><strong>Primeira ação de amanhã</strong> — não "continuar o relatório", e sim "abrir a planilha X e conferir o total da seção 3".</li>
        </ul>
        <p>
            Quanto mais específico, mais forte o efeito de "fechamento cognitivo" (lembra do artigo
            anterior?).
        </p>

        <h2 class="text-lg font-semibold mt-6 mb-2">3. Faça o Check-in Matinal</h2>
        <p>
            No dia seguinte, antes de mergulhar no trabalho, abra o Check-in. Ele mostra exatamente o
            plano que você deixou pra si mesmo ontem — sem precisar reconstruir o contexto do zero.
        </p>

        <h2 class="text-lg font-semibold mt-6 mb-2">4. Use a Agenda em conjunto</h2>
        <p>
            Compromissos com horário (reuniões, prazos, chamadas) entram na Agenda, não nas tarefas.
            A diferença: o Ritual mostra automaticamente "amanhã você tem" com os compromissos do dia
            seguinte, e o Check-in mostra "hoje você tem" — assim você fecha o loop também sobre sua
            agenda, não só sobre as tarefas soltas.
        </p>

        <div class="bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 my-6">
            <p class="text-sm text-[var(--accent-soft-text)] font-medium mb-2">Dicas rápidas</p>
            <ul class="text-sm text-[var(--accent-soft-text)] list-disc pl-4 space-y-1">
                <li>Não deixe o ritual pro último minuto correndo — ele funciona melhor com calma.</li>
                <li>Se uma tarefa realmente terminou, marque como encerrada em vez de registrar um loop.</li>
                <li>Use tags nas tarefas pra agrupar por projeto ou urgência.</li>
                <li>Confira o Histórico de vez em quando — ver o streak de rituais ajuda a manter o hábito.</li>
            </ul>
        </div>

        <h2 class="text-lg font-semibold mt-6 mb-2">Perguntas frequentes</h2>
        <p><strong>E se eu esquecer de fazer o ritual num dia?</strong> Sem problema — o streak simplesmente reinicia, e no dia seguinte o Check-in não vai ter nada de ontem. O sistema continua funcionando normalmente.</p>
        <p><strong>Preciso fechar todas as tarefas todo dia?</strong> Não — o objetivo é registrar onde parou, não terminar tudo. Tarefas continuam abertas até você de fato concluí-las.</p>
    </div>

    @include('biblioteca._nav')
@endsection
