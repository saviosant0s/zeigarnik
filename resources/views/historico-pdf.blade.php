<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório semanal · Zeigarnik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-[#F4F0E8] text-[#2A2722] p-8 max-w-2xl mx-auto">
    <div class="no-print mb-6 flex gap-2">
        <button onclick="window.print()" class="bg-[#0F0F10] text-white rounded-lg px-4 py-2 text-sm font-medium">
            Salvar como PDF / Imprimir
        </button>
        <a href="{{ route('historico') }}" class="bg-white border border-[#DDD5C7] rounded-lg px-4 py-2 text-sm">Voltar</a>
    </div>

    <h1 class="text-xl font-bold mb-1">Relatório de Fechamento Semanal</h1>
    <p class="text-sm text-[#8A8171] mb-8">
        {{ $inicio->translatedFormat('d \d\e F') }} a {{ $fim->translatedFormat('d \d\e F, Y') }}
    </p>

    @forelse ($entriesPorDia as $data => $entries)
        <div class="mb-6 break-inside-avoid">
            <div class="flex items-center gap-2 mb-2 border-b border-[#DDD5C7] pb-1">
                <h2 class="text-sm font-semibold">{{ \Carbon\Carbon::parse($data)->translatedFormat('l, d \d\e F') }}</h2>
                @if (isset($rituais[$data]) && $rituais[$data]->humor_saida)
                    <span class="text-xs text-[#8A8171]">humor {{ $rituais[$data]->humor_saida }}/5</span>
                @endif
            </div>
            <ul class="space-y-2">
                @foreach ($entries as $entry)
                    <li class="text-sm">
                        <p class="font-medium">{{ $entry->task->title }}</p>
                        <p class="text-xs text-[#8A8171]">Onde parou: {{ $entry->onde_parei }}</p>
                        <p class="text-xs text-[#3A3A3A]">Próxima ação: {{ $entry->proxima_acao }}</p>
                        @if ($entry->bloqueios)
                            <p class="text-xs text-[#8A4A4A]">Bloqueio: {{ $entry->bloqueios }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p class="text-sm text-[#A79E8C]">Nenhum loop fechado nessa semana.</p>
    @endforelse
</body>
</html>
