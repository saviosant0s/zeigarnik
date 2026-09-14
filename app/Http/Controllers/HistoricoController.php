<?php

namespace App\Http\Controllers;

use App\Models\DailyRitual;
use App\Models\LoopEntry;
use Illuminate\View\View;

class HistoricoController extends Controller
{
    public function index(): View
    {
        $entries = LoopEntry::with('task')
            ->orderByDesc('date')
            ->get()
            ->groupBy(fn ($entry) => $entry->date->toDateString());

        $rituais = DailyRitual::whereNotNull('finished_at')
            ->orderByDesc('date')
            ->get()
            ->keyBy(fn ($r) => $r->date->toDateString());

        $streak = $this->calcularStreak($rituais->keys()->all());

        return view('historico', [
            'entriesPorDia' => $entries,
            'rituais' => $rituais,
            'streak' => $streak,
        ]);
    }

    public function exportarSemana(): View
    {
        $inicio = today()->startOfWeek();
        $fim = today()->endOfWeek();

        $entries = LoopEntry::with('task')
            ->whereBetween('date', [$inicio, $fim])
            ->orderBy('date')
            ->get()
            ->groupBy(fn ($entry) => $entry->date->toDateString());

        $rituais = DailyRitual::whereBetween('date', [$inicio, $fim])
            ->whereNotNull('finished_at')
            ->get()
            ->keyBy(fn ($r) => $r->date->toDateString());

        return view('historico-pdf', [
            'entriesPorDia' => $entries,
            'rituais' => $rituais,
            'inicio' => $inicio,
            'fim' => $fim,
        ]);
    }

    private function calcularStreak(array $datasComRitual): int
    {
        $datas = collect($datasComRitual)->sort()->values();
        if ($datas->isEmpty()) {
            return 0;
        }

        $streak = 1;
        $atual = \Carbon\Carbon::parse($datas->last());

        // conta pra trás enquanto os dias forem consecutivos (ignorando fins de semana)
        for ($i = $datas->count() - 2; $i >= 0; $i--) {
            $anterior = \Carbon\Carbon::parse($datas[$i]);
            $diff = $anterior->diffInDays($atual);

            if ($diff <= 3 && $anterior->lt($atual)) {
                $streak++;
                $atual = $anterior;
            } else {
                break;
            }
        }

        return $streak;
    }
}
