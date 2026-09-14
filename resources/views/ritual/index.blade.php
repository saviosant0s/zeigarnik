@extends('layouts.zeigarnik')

@section('title', 'Ritual de Encerramento · Zeigarnik')

@section('content')
    <div x-data="{ segundos: 900, notificado: false }"
         x-init="
            if ('Notification' in window && Notification.permission === 'default') { Notification.requestPermission() }
            const t = setInterval(() => {
                if (segundos > 0) {
                    segundos--
                    if (segundos === 60 && !notificado) {
                        notificado = true
                        if ('Notification' in window && Notification.permission === 'granted') {
                            new Notification('Zeigarnik', { body: 'Falta 1 minuto pra fechar o ritual de encerramento.' })
                        }
                    }
                } else { clearInterval(t) }
            }, 1000)
         "
         class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-5 mb-6 mt-2 text-center">
        <p class="text-xs text-[var(--text-muted)] uppercase tracking-wide mb-1">Ritual de Encerramento</p>
        <span class="text-4xl font-bold font-mono tracking-tight"
            :class="segundos <= 60 ? 'text-[var(--danger-text)]' : 'text-[var(--text)]'"
            x-text="`${String(Math.floor(segundos/60)).padStart(2,'0')}:${String(segundos%60).padStart(2,'0')}`">
        </span>
        <p class="text-[var(--text-muted)] text-xs mt-2">Feche cada loop: onde parou + próxima ação.</p>
    </div>

    <ul class="space-y-2 mb-8">
        @forelse ($tasks as $task)
            <li>
                <a href="{{ route('ritual.form', $task) }}" class="flex items-center justify-between bg-[var(--surface)] border border-[var(--border)] rounded-2xl px-4 py-4 active:bg-[var(--bg)]">
                    <span class="font-medium text-[15px]">{{ $task->title }}</span>
                    <span class="text-xs text-[#6B7A5E] font-medium">Registrar →</span>
                </a>
            </li>
        @empty
            <li class="text-[var(--text-faint)] text-sm py-4 text-center">Nenhuma tarefa aberta para encerrar.</li>
        @endforelse
    </ul>

    <form action="{{ route('ritual.finish') }}" method="POST" class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 space-y-4">
        @csrf
        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">Humor de saída</label>
            <div class="grid grid-cols-5 gap-2">
                @for ($i = 1; $i <= 5; $i++)
                    <label class="cursor-pointer">
                        <input type="radio" name="humor_saida" value="{{ $i }}" class="peer sr-only">
                        <span class="flex items-center justify-center h-12 rounded-xl bg-[var(--bg)] border border-[var(--border)] peer-checked:bg-[#6B7A5E] peer-checked:border-[#6B7A5E] peer-checked:text-white text-[15px] font-medium">{{ $i }}</span>
                    </label>
                @endfor
            </div>
        </div>
        <textarea name="observacoes" placeholder="Observações (opcional)..." rows="2"
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[#6B7A5E]"></textarea>
        <button class="w-full bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl py-3.5 text-[15px] font-semibold">
            Encerrar o dia
        </button>
    </form>
@endsection
