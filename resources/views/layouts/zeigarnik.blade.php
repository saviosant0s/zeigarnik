<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zeigarnik')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen">
    <nav class="border-b border-slate-800 px-6 py-4 flex gap-6 items-center">
        <span class="font-semibold text-slate-300">🧠 Zeigarnik</span>
        <a href="{{ route('dashboard') }}" class="text-sm text-slate-400 hover:text-white">Dashboard</a>
        <a href="{{ route('ritual.index') }}" class="text-sm text-slate-400 hover:text-white">Ritual de Encerramento</a>
        <a href="{{ route('checkin') }}" class="text-sm text-slate-400 hover:text-white">Check-in</a>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-10">
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-emerald-900/40 border border-emerald-700 text-emerald-200 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
