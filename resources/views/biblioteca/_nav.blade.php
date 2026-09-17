@php $a = $anterior ?? null; $p = $proximo ?? null; @endphp

<div class="mt-8">
    @if (! $lido)
        <form action="{{ route('biblioteca.marcar-lido', $slug) }}" method="POST">
            @csrf
            <button class="w-full bg-[var(--accent)] text-white dark:text-[#0F0F10] rounded-xl py-3.5 text-[15px] font-semibold">
                Marcar como lido
            </button>
        </form>
    @else
        <div class="flex items-center justify-center gap-2 text-[var(--accent-soft-text)] bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-xl py-3.5 text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 13 4 4L19 7"/></svg>
            Lido
        </div>
    @endif
</div>

<div class="flex items-center justify-between mt-4 pt-4 border-t border-[var(--border)] text-sm">
    @if ($a)
        <a href="{{ route('biblioteca.show', $a['slug']) }}" class="flex items-center gap-1 text-[var(--text-muted)] min-w-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            <span class="truncate">{{ $a['titulo'] }}</span>
        </a>
    @else
        <span></span>
    @endif

    @if ($p)
        <a href="{{ route('biblioteca.show', $p['slug']) }}" class="flex items-center gap-1 text-[var(--text-muted)] min-w-0 text-right">
            <span class="truncate">{{ $p['titulo'] }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
    @endif
</div>
