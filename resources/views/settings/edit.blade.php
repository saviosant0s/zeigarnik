@extends('layouts.zeigarnik')

@section('title', 'Configurações · Zeigarnik')

@section('content')
    <h1 class="text-[22px] font-bold mb-1 mt-2">Configurações</h1>
    <p class="text-[var(--text-muted)] text-sm mb-2">SMTP para lembretes por e-mail.</p>
    <p class="text-xs text-[var(--danger-text)] mb-6">
        ⚠ Sem sistema de usuários ainda — quando existir, esta tela passa a ser exclusiva do super admin.
    </p>

    @if (session('erro'))
        <div class="mb-4 rounded-2xl bg-[#F3DEDE] border border-[var(--danger-text)] text-[var(--danger-text)] px-4 py-3 text-sm">
            {{ session('erro') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" class="bg-[var(--surface)] border border-[var(--border)] rounded-2xl p-4 space-y-4">
        @csrf
        @method('PUT')

        <label class="flex items-center justify-between text-sm py-1">
            <span class="text-[var(--text-muted)]">Ativar lembretes por e-mail</span>
            <input type="checkbox" name="notify_enabled" value="1" {{ $settings->notify_enabled ? 'checked' : '' }} class="w-5 h-5 rounded">
        </label>

        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">Host SMTP</label>
            <input type="text" name="mail_host" placeholder="smtp.gmail.com" value="{{ old('mail_host', $settings->mail_host) }}"
                class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <label class="text-sm text-[var(--text-muted)] block mb-2">Porta</label>
                <input type="text" name="mail_port" placeholder="587" value="{{ old('mail_port', $settings->mail_port) }}"
                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
            </div>
            <div class="flex-1">
                <label class="text-sm text-[var(--text-muted)] block mb-2">Criptografia</label>
                <select name="mail_encryption" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
                    <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) === 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) === 'ssl' ? 'selected' : '' }}>SSL</option>
                    <option value="" {{ ! $settings->mail_encryption ? 'selected' : '' }}>Nenhuma</option>
                </select>
            </div>
        </div>

        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">Usuário SMTP</label>
            <input type="text" name="mail_username" value="{{ old('mail_username', $settings->mail_username) }}"
                class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        </div>

        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">Senha SMTP</label>
            <input type="password" name="mail_password" placeholder="{{ $settings->mail_password ? '•••••••• (deixe vazio pra manter)' : '' }}"
                class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        </div>

        <div class="flex gap-2">
            <div class="flex-1">
                <label class="text-sm text-[var(--text-muted)] block mb-2">E-mail remetente</label>
                <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings->mail_from_address) }}"
                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
            </div>
            <div class="flex-1">
                <label class="text-sm text-[var(--text-muted)] block mb-2">Nome remetente</label>
                <input type="text" name="mail_from_name" placeholder="Zeigarnik" value="{{ old('mail_from_name', $settings->mail_from_name) }}"
                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-3 py-3 text-[15px]">
            </div>
        </div>

        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">E-mail que recebe os lembretes</label>
            <input type="email" name="notify_email" value="{{ old('notify_email', $settings->notify_email) }}"
                class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        </div>

        <div>
            <label class="text-sm text-[var(--text-muted)] block mb-2">Avisar quantos minutos antes</label>
            <input type="number" name="notify_minutes_before" min="1" max="180" value="{{ old('notify_minutes_before', $settings->notify_minutes_before) }}"
                class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-3 text-[15px]">
        </div>

        <button class="w-full bg-[#6B7A5E] active:bg-[#5C6A50] text-white rounded-xl py-3.5 text-[15px] font-semibold">
            Salvar configurações
        </button>
    </form>

    <form action="{{ route('settings.testar') }}" method="POST" class="mt-3">
        @csrf
        <button class="w-full bg-[var(--surface)] border border-[var(--border)] text-[var(--text)] rounded-xl py-3 text-sm font-medium">
            Enviar e-mail de teste
        </button>
    </form>

    <div class="mt-6 bg-[var(--accent-soft-bg)] border border-[var(--accent-soft-border)] rounded-2xl p-4 text-xs text-[var(--accent-soft-text)]">
        Pra ativar de verdade, configure um serviço de cron externo gratuito (ex: cron-job.org) pra chamar
        <code class="bg-black/10 px-1 rounded">{{ url('/cron/lembretes') }}</code> a cada minuto.
    </div>
@endsection
