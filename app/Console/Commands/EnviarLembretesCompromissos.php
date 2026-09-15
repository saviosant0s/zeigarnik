<?php

namespace App\Console\Commands;

use App\Models\AppSetting;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarLembretesCompromissos extends Command
{
    protected $signature = 'zeigarnik:lembretes';
    protected $description = 'Verifica compromissos próximos e envia e-mail de lembrete (roda a cada minuto)';

    public function handle(): int
    {
        $settings = AppSetting::current();

        if (! $settings->notify_enabled || ! $settings->notify_email || ! $settings->mail_host) {
            $this->info('Notificação por e-mail desativada ou SMTP não configurado. Nada a fazer.');
            return self::SUCCESS;
        }

        $settings->aplicarNoRuntime();

        $alvo = now()->addMinutes($settings->notify_minutes_before);

        $compromissos = Appointment::whereDate('date', $alvo->toDateString())
            ->whereNotNull('time_start')
            ->where('done', false)
            ->whereNull('reminder_at') // ainda não avisado
            ->get()
            ->filter(function ($a) use ($alvo) {
                $horario = \Carbon\Carbon::parse($a->date->toDateString() . ' ' . $a->time_start);
                // dispara numa janela de 1 minuto em volta do horário alvo
                return $horario->diffInMinutes($alvo, false) === 0 || abs($horario->diffInSeconds($alvo)) < 60;
            });

        foreach ($compromissos as $a) {
            try {
                Mail::raw(
                    "Lembrete: \"{$a->title}\" às " . \Carbon\Carbon::parse($a->time_start)->format('H:i') .
                    ($a->location ? " ({$a->location})" : ''),
                    fn ($msg) => $msg->to($settings->notify_email)->subject('Zeigarnik — lembrete de compromisso')
                );
                $a->update(['reminder_at' => now()]);
                $this->info("Lembrete enviado: {$a->title}");
            } catch (\Throwable $e) {
                $this->error("Falha ao enviar lembrete de \"{$a->title}\": " . $e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}
