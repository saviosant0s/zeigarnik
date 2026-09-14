<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zeigarnik')</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#F4F0E8] text-[#2A2722] min-h-screen">
    <nav class="border-b border-[#DDD5C7] px-6 py-4 flex gap-6 items-center">
        <span class="font-semibold text-[#2A2722] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#6B7A5E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            Zeigarnik
        </span>
        <a href="{{ route('dashboard') }}" class="text-sm text-[#8A8171] hover:text-[#2A2722]">Dashboard</a>
        <a href="{{ route('ritual.index') }}" class="text-sm text-[#8A8171] hover:text-[#2A2722]">Ritual de Encerramento</a>
        <a href="{{ route('checkin') }}" class="text-sm text-[#8A8171] hover:text-[#2A2722]">Check-in</a>
    </nav>

    <main class="max-w-3xl mx-auto px-6 py-10">
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-[#EAF0E4] border border-[#B9C9A9] text-[#4C5A3E] px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
