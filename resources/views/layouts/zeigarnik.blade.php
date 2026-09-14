<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Zeigarnik')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { -webkit-tap-highlight-color: transparent; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
    </style>
</head>
<body class="bg-[#F4F0E8] text-[#2A2722] min-h-screen">
    <!-- Topo: apenas marca + status, sem navegação (nav fica embaixo, no thumb zone) -->
    <header class="px-4 pt-6 pb-2 flex items-center gap-2 max-w-lg mx-auto">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6B7A5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        <span class="font-semibold text-[15px] tracking-tight">Zeigarnik</span>
    </header>

    <main class="max-w-lg mx-auto px-4 pb-32 pt-2">
        @if (session('status'))
            <div class="mb-4 rounded-2xl bg-[#EAF0E4] border border-[#B9C9A9] text-[#4C5A3E] px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Nav inferior fixa: thumb zone, 4 destinos, ícone + label -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-[#DDD5C7] safe-bottom">
        <div class="max-w-lg mx-auto grid grid-cols-4">
            @php
                $items = [
                    ['route' => 'dashboard', 'label' => 'Início', 'icon' => 'M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5Z'],
                    ['route' => 'ritual.index', 'label' => 'Ritual', 'icon' => 'M12 8v4l3 2M21 12a9 9 0 1 1-9-9 9 9 0 0 1 9 9Z'],
                    ['route' => 'checkin', 'label' => 'Check-in', 'icon' => 'm5 13 4 4L19 7'],
                    ['route' => 'historico', 'label' => 'Histórico', 'icon' => 'M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8M3 3v5h5M12 7v5l4 2'],
                ];
            @endphp
            @foreach ($items as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex flex-col items-center justify-center gap-1 py-3 text-[11px] {{ $active ? 'text-[#6B7A5E]' : 'text-[#A79E8C]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="{{ $active ? '#6B7A5E' : '#A79E8C' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="{{ $item['icon'] }}"/>
                    </svg>
                    <span class="{{ $active ? 'font-semibold' : '' }}">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>
</body>
</html>
