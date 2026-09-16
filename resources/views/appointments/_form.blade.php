@php $a = $appointment ?? null; @endphp

<div>
    <label class="text-sm text-[var(--text-muted)] block mb-2">Título</label>
    <input type="text" name="title" required value="{{ old('title', $a->title ?? '') }}"
        class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
</div>

<div class="flex gap-2">
    <div class="flex-1">
        <label class="text-sm text-[var(--text-muted)] block mb-2">Data</label>
        <input type="date" name="date" required value="{{ old('date', $a?->date?->toDateString()) }}"
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
    </div>
    <div>
        <label class="text-sm text-[var(--text-muted)] block mb-2">Tipo</label>
        <select name="type" class="bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
            @foreach (['reuniao' => 'Reunião', 'prazo' => 'Prazo', 'chamada' => 'Chamada', 'outro' => 'Outro'] as $val => $label)
                <option value="{{ $val }}" {{ old('type', $a->type ?? 'outro') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="flex gap-2">
    <div class="flex-1">
        <label class="text-sm text-[var(--text-muted)] block mb-2">Início</label>
        <input type="time" name="time_start" value="{{ old('time_start', $a?->time_start ? \Carbon\Carbon::parse($a->time_start)->format('H:i') : '') }}"
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
    </div>
    <div class="flex-1">
        <label class="text-sm text-[var(--text-muted)] block mb-2">Fim</label>
        <input type="time" name="time_end" value="{{ old('time_end', $a?->time_end ? \Carbon\Carbon::parse($a->time_end)->format('H:i') : '') }}"
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
    </div>
</div>

<div>
    <label class="text-sm text-[var(--text-muted)] block mb-2">Local (opcional)</label>
    <input type="text" name="location" placeholder="Sala 2, Google Meet..." value="{{ old('location', $a->location ?? '') }}"
        class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
</div>

<div>
    <label class="text-sm text-[var(--text-muted)] block mb-2">Observações (opcional)</label>
    <textarea name="notes" rows="2"
        class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">{{ old('notes', $a->notes ?? '') }}</textarea>
</div>

@if (! $a)
<div x-data="{ recorrencia: '{{ old('recurrence', 'nenhuma') }}' }">
    <label class="text-sm text-[var(--text-muted)] block mb-2">Repetir</label>
    <select name="recurrence" x-model="recorrencia" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px] mb-2">
        <option value="nenhuma">Não repetir</option>
        <option value="diaria">Todo dia</option>
        <option value="semanal">Toda semana</option>
        <option value="mensal">Todo mês</option>
    </select>
    <div x-show="recorrencia !== 'nenhuma'" x-cloak>
        <label class="text-sm text-[var(--text-muted)] block mb-2">Repetir até</label>
        <input type="date" name="recurrence_until" value="{{ old('recurrence_until') }}"
            class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px] focus:outline-none focus:border-[var(--accent)]">
    </div>
</div>
@endif
