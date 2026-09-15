<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * NOTA: sem sistema de usuários ainda, esta tela está acessível por
 * qualquer um que tenha a URL. Quando houver auth, restringir ao
 * super admin (ver comentário em App\Models\AppSetting).
 */
class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('settings.edit', ['settings' => AppSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|string|max:10',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl,',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|string|max:255',
            'notify_email' => 'nullable|email|max:255',
            'notify_minutes_before' => 'nullable|integer|min:1|max:180',
            'notify_enabled' => 'nullable|boolean',
        ]);

        $data['notify_enabled'] = $request->boolean('notify_enabled');

        // não sobrescreve a senha salva se o campo vier vazio (usuário não quis trocar)
        if (empty($data['mail_password'])) {
            unset($data['mail_password']);
        }

        $settings = AppSetting::current();
        $settings->update($data);

        return redirect()->route('settings.edit')->with('status', 'Configurações salvas.');
    }

    public function testar(Request $request): RedirectResponse
    {
        $settings = AppSetting::current();
        $settings->aplicarNoRuntime();

        try {
            \Illuminate\Support\Facades\Mail::raw(
                'Este é um e-mail de teste do Zeigarnik. Se você recebeu isso, o SMTP está funcionando!',
                fn ($msg) => $msg->to($settings->notify_email)->subject('Zeigarnik — teste de SMTP')
            );

            return redirect()->route('settings.edit')->with('status', 'E-mail de teste enviado para ' . $settings->notify_email);
        } catch (\Throwable $e) {
            return redirect()->route('settings.edit')->with('erro', 'Falha ao enviar: ' . $e->getMessage());
        }
    }
}
