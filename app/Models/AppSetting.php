<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ATENÇÃO (nota pra quando o sistema tiver autenticação/usuários):
 * Esta tela de configurações (SMTP, notificações) deve passar a ser
 * acessível SOMENTE pelo super admin. Hoje não há usuários/permissões
 * no sistema, então a rota /configuracoes está aberta por padrão.
 * Quando implementar auth, proteger a rota com um middleware tipo
 * `can:manage-settings` ou `role:super-admin`.
 */
class AppSetting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = [
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'notify_email',
        'notify_minutes_before',
        'notify_enabled',
    ];

    protected $casts = [
        'mail_password' => 'encrypted',
        'notify_enabled' => 'boolean',
        'notify_minutes_before' => 'integer',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }

    /**
     * Aplica essas configurações no runtime do Laravel (config/mail.php)
     * pra que Mail::send() use o SMTP salvo no banco em vez do .env.
     */
    public function aplicarNoRuntime(): void
    {
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $this->mail_host,
            'mail.mailers.smtp.port' => $this->mail_port,
            'mail.mailers.smtp.username' => $this->mail_username,
            'mail.mailers.smtp.password' => $this->mail_password,
            'mail.mailers.smtp.encryption' => $this->mail_encryption ?: null,
            'mail.from.address' => $this->mail_from_address,
            'mail.from.name' => $this->mail_from_name ?: 'Zeigarnik',
        ]);
    }
}
