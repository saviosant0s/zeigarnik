<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Zeigarnik')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script>
        // aplica o tema antes do primeiro paint, evita flash de tela clara
        if (localStorage.getItem('zeigarnik-theme') === 'dark' ||
            (!localStorage.getItem('zeigarnik-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { -webkit-tap-highlight-color: transparent; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
        :root {
            --bg: #F4F0E8;
            --surface: #FFFFFF;
            --border: #DDD5C7;
            --text: #2A2722;
            --text-muted: #8A8171;
            --text-faint: #A79E8C;
            --accent-soft-bg: #EAF0E4;
            --accent-soft-border: #B9C9A9;
            --accent-soft-text: #4C5A3E;
            --danger-text: #8A4A4A;
        }
        html.dark {
            --bg: #211F1B;
            --surface: #2C2A25;
            --border: #423F37;
            --text: #F0ECE3;
            --text-muted: #A79E8C;
            --text-faint: #7D7566;
            --accent-soft-bg: #2A3327;
            --accent-soft-border: #45543D;
            --accent-soft-text: #A9C79A;
            --danger-text: #D18F8F;
        }
        body { transition: background-color .15s ease, color .15s ease; }
    </style>
</head>
<body class="bg-[var(--bg)] text-[var(--text)] min-h-screen">
    <!-- Topo: marca + toggle de tema -->
    <header class="px-4 pt-6 pb-2 flex items-center justify-between max-w-lg mx-auto">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 shrink-0" viewBox="0 0 24 24" fill="none" stroke="#6B7A5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span class="font-semibold text-[15px] tracking-tight">Zeigarnik</span>
        </div>
        <button
            x-data
            @click="
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('zeigarnik-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            "
            class="w-9 h-9 flex items-center justify-center rounded-full border border-[var(--border)] text-[var(--text-muted)]"
            aria-label="Alternar tema">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 hidden dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/>
            </svg>
        </button>
    </header>

    <main class="max-w-lg mx-auto px-4 pb-32 pt-2">
        @if (session('status'))
            <div class="mb-4 rounded-2xl bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] text-[var(--accent-soft-text)] px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Nav inferior fixa: thumb zone, 4 destinos, ícone + label -->
    <nav class="fixed bottom-0 left-0 right-0 bg-[var(--surface)] border-t border-[var(--border)] safe-bottom">
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
                   class="flex flex-col items-center justify-center gap-1 py-3 text-[11px] {{ $active ? 'text-[#6B7A5E]' : 'text-[var(--text-faint)]' }}">
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
