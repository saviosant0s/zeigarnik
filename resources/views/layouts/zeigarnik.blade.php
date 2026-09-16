<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Zeigarnik')</title>
    <link rel="icon" type="image/png" href="/images/icon.png">
    <link rel="apple-touch-icon" href="/images/icon.png">
    <script>
        if (localStorage.getItem('zeigarnik-theme') === 'dark' ||
            (!localStorage.getItem('zeigarnik-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { -webkit-tap-highlight-color: transparent; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
        h1 { font-family: 'Playfair Display', serif; letter-spacing: -0.01em; }
        :root {
            --bg: #F7F5EE;
            --surface: #FFFFFF;
            --border: #E4DBC9;
            --text: #0F0F10;
            --text-muted: #3A3A3A;
            --text-faint: #8A8171;
            --accent: #0F0F10;
            --accent-hover: #2A2A2C;
            --accent-soft-bg: #DCCFB8;
            --accent-soft-border: #C9B99C;
            --accent-soft-text: #3A3A3A;
            --danger-text: #8A4A4A;
        }
        html.dark {
            --bg: #0F0F10;
            --surface: #1C1C1D;
            --border: #333233;
            --text: #F7F5EE;
            --text-muted: #C9C2B4;
            --text-faint: #7D7566;
            --accent: #DCCFB8;
            --accent-hover: #C9B99C;
            --accent-soft-bg: #262523;
            --accent-soft-border: #45433C;
            --accent-soft-text: #DCCFB8;
            --danger-text: #D18F8F;
        }
        /* no dark mode, botões de accent (bege marfim) precisam de texto escuro, não branco */
        html.dark .btn-accent-text { color: #0F0F10 !important; }
        body { transition: background-color .15s ease, color .15s ease; }
    </style>
</head>
<body class="bg-[var(--bg)] text-[var(--text)] min-h-screen">
    <!-- Topo: marca + toggle de tema -->
    <header class="px-4 pt-6 pb-2 flex items-center justify-between max-w-lg mx-auto">
        <div class="flex items-center gap-2">
            <img src="/images/icon.png" alt="Zeigarnik" class="w-8 h-8 rounded-lg shrink-0">
            <span class="font-semibold text-[16px] tracking-tight" style="font-family: 'Playfair Display', serif;">Zeigarnik</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('settings.edit') }}" class="text-[var(--text-faint)]" aria-label="Configurações">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="2.5"/>
                    <path d="M12 5v2.2M12 16.8V19M19 12h-2.2M7.2 12H5M16.6 7.4l-1.6 1.6M9 15l-1.6 1.6M16.6 16.6 15 15M9 9 7.4 7.4"/>
                </svg>
            </a>
            <button
                x-data
                @click="
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('zeigarnik-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                "
                class="text-[var(--text-faint)]"
                aria-label="Alternar tema">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3.5"/>
                    <path d="M12 3.5v1.8M12 18.7v1.8M20.5 12h-1.8M5.3 12H3.5M17.7 6.3l-1.3 1.3M7.6 16.1l-1.3 1.3M17.7 17.7l-1.3-1.3M7.6 7.9 6.3 6.6"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] hidden dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 14.5A8.5 8.5 0 1 1 9.5 4a6.7 6.7 0 0 0 10.5 10.5Z"/>
                </svg>
            </button>
        </div>
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
        <div class="max-w-lg mx-auto grid grid-cols-5">
            @php
                $items = [
                    ['route' => 'dashboard', 'label' => 'Início', 'icon' => 'M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5Z'],
                    ['route' => 'ritual.index', 'label' => 'Ritual', 'icon' => 'M12 8v4l3 2M21 12a9 9 0 1 1-9-9 9 9 0 0 1 9 9Z'],
                    ['route' => 'appointments.index', 'label' => 'Agenda', 'icon' => 'M8 2v3M16 2v3M3.5 8h17M5 4h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1Z'],
                    ['route' => 'checkin', 'label' => 'Check-in', 'icon' => 'm5 13 4 4L19 7'],
                    ['route' => 'historico', 'label' => 'Histórico', 'icon' => 'M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8M3 3v5h5M12 7v5l4 2'],
                ];
            @endphp
            @foreach ($items as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex flex-col items-center justify-center gap-1 py-3 text-[11px] {{ $active ? 'text-[var(--accent)]' : 'text-[var(--text-faint)]' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="{{ $active ? 'var(--accent)' : '#A79E8C' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="{{ $item['icon'] }}"/>
                    </svg>
                    <span class="{{ $active ? 'font-semibold' : '' }}">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </nav>
</body>
</html>
