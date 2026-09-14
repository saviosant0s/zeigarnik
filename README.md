# Sistema Zeigarnik

Ferramenta pessoal de ritual de encerramento baseada no Efeito Zeigarnik.
Registre onde parou em cada tarefa + o que fazer amanhã, em 15 minutos antes de sair do trabalho.
O cérebro para de ruminar porque os loops ficam fechados no papel.

## Stack

Laravel + SQLite + Blade + Alpine.js + Tailwind (via CDN) — sem build, sem node, sem auth (uso pessoal).

## Rodando localmente

```bash
composer install
copy .env.example .env      # Windows (cp no Linux/Mac)
php artisan key:generate

# criar o arquivo do banco (Windows: type nul > database\database.sqlite)
touch database/database.sqlite

php artisan migrate
php artisan serve
```

Acesse `http://localhost:8000`.

## Fluxo

`Dashboard` → `Ritual de Encerramento` (15 min, timer embutido) → `Check-in Matinal`

## Status

✅ MVP funcional: dashboard, ritual de encerramento com timer, check-in matinal, humor de saída.

### Próximos passos (V2)
- Histórico de loops fechados
- Streak de rituais consecutivos
- Exportar semana em PDF
- Tags nas tarefas
- Campo "bloqueios"
