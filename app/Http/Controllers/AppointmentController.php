<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $referencia = $request->has('semana')
            ? Carbon::parse($request->query('semana'))
            : today();

        $inicio = $referencia->copy()->startOfWeek();
        $fim = $referencia->copy()->endOfWeek();

        $tipo = $request->query('tipo');

        $query = Appointment::daSemana($inicio, $fim)->orderBy('date')->orderBy('time_start');
        if ($tipo) {
            $query->where('type', $tipo);
        }
        $appointments = $query->get()->groupBy(fn ($a) => $a->date->toDateString());

        $conflitos = [];
        foreach ($appointments as $data => $itens) {
            $comHora = $itens->filter(fn ($a) => $a->time_start && $a->time_end)->values();
            for ($i = 0; $i < $comHora->count(); $i++) {
                for ($j = $i + 1; $j < $comHora->count(); $j++) {
                    $a = $comHora[$i];
                    $b = $comHora[$j];
                    if ($a->time_start < $b->time_end && $b->time_start < $a->time_end) {
                        $conflitos[$a->id] = true;
                        $conflitos[$b->id] = true;
                    }
                }
            }
        }

        $dias = collect(range(0, 6))->map(fn ($i) => $inicio->copy()->addDays($i));

        return view('appointments.index', [
            'appointments' => $appointments,
            'dias' => $dias,
            'inicio' => $inicio,
            'fim' => $fim,
            'tipoAtivo' => $tipo,
            'conflitos' => $conflitos,
        ]);
    }

    public function create(): View
    {
        return view('appointments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $recorrencia = $data['recurrence'] ?? 'nenhuma';

        if ($recorrencia !== 'nenhuma' && ! empty($data['recurrence_until'])) {
            $grupo = (string) Str::uuid();
            $data['recurrence_group'] = $grupo;

            $atual = Carbon::parse($data['date']);
            $limite = Carbon::parse($data['recurrence_until']);

            $criadas = 0;
            while ($atual->lte($limite) && $criadas < 60) {
                Appointment::create(array_merge($data, ['date' => $atual->toDateString()]));
                $criadas++;
                $atual = match ($recorrencia) {
                    'diaria' => $atual->copy()->addDay(),
                    'semanal' => $atual->copy()->addWeek(),
                    'mensal' => $atual->copy()->addMonthNoOverflow(),
                    default => $limite->copy()->addDay(), // encerra o loop
                };
            }
        } else {
            Appointment::create($data);
        }

        return redirect()->route('appointments.index')->with('status', 'Compromisso adicionado.');
    }

    public function edit(Appointment $appointment): View
    {
        return view('appointments.edit', ['appointment' => $appointment]);
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $data = $this->validated($request);
        $data['done'] = $request->boolean('done');
        $appointment->update($data);

        return redirect()->route('appointments.index')->with('status', 'Compromisso atualizado.');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('status', 'Compromisso removido.');
    }

    public function destroySerie(Appointment $appointment): RedirectResponse
    {
        if ($appointment->recurrence_group) {
            Appointment::where('recurrence_group', $appointment->recurrence_group)->delete();
        } else {
            $appointment->delete();
        }

        return redirect()->route('appointments.index')->with('status', 'Série removida.');
    }

    public function toggleDone(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['done' => ! $appointment->done]);

        return back();
    }

    public function moverData(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate(['date' => 'required|date']);
        $appointment->update(['date' => $request->input('date')]);

        return back();
    }

    public function exportarIcs(): Response
    {
        $appointments = Appointment::orderBy('date')->orderBy('time_start')->get();

        $ics = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Zeigarnik//Agenda//PT\r\n";
        foreach ($appointments as $a) {
            $start = Carbon::parse($a->date->toDateString() . ' ' . ($a->time_start ?? '09:00:00'));
            $end = Carbon::parse($a->date->toDateString() . ' ' . ($a->time_end ?? $a->time_start ?? '09:30:00'));
            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:zeigarnik-{$a->id}@zeigarnik\r\n";
            $ics .= "DTSTART:" . $start->format('Ymd\THis') . "\r\n";
            $ics .= "DTEND:" . $end->format('Ymd\THis') . "\r\n";
            $ics .= "SUMMARY:" . $this->escapeIcs($a->title) . "\r\n";
            if ($a->location) {
                $ics .= "LOCATION:" . $this->escapeIcs($a->location) . "\r\n";
            }
            if ($a->notes) {
                $ics .= "DESCRIPTION:" . $this->escapeIcs($a->notes) . "\r\n";
            }
            $ics .= "END:VEVENT\r\n";
        }
        $ics .= "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="zeigarnik-agenda.ics"',
        ]);
    }

    public function importarIcsForm(): View
    {
        return view('appointments.importar');
    }

    public function importarIcs(Request $request): RedirectResponse
    {
        $request->validate(['arquivo' => 'required|file']);
        $conteudo = file_get_contents($request->file('arquivo')->getRealPath());

        preg_match_all('/BEGIN:VEVENT(.*?)END:VEVENT/s', $conteudo, $eventos);

        $importados = 0;
        foreach ($eventos[1] as $bloco) {
            $titulo = $this->extrairCampoIcs($bloco, 'SUMMARY') ?? 'Sem título';
            $local = $this->extrairCampoIcs($bloco, 'LOCATION');
            $dtStart = $this->extrairCampoIcs($bloco, 'DTSTART');
            $dtEnd = $this->extrairCampoIcs($bloco, 'DTEND');

            if (! $dtStart) {
                continue;
            }

            $inicio = $this->parseIcsData($dtStart);
            $fim = $dtEnd ? $this->parseIcsData($dtEnd) : null;

            if (! $inicio) {
                continue;
            }

            Appointment::create([
                'title' => $titulo,
                'type' => 'outro',
                'date' => $inicio->toDateString(),
                'time_start' => $inicio->format('H:i:s'),
                'time_end' => $fim?->format('H:i:s'),
                'location' => $local,
            ]);
            $importados++;
        }

        return redirect()->route('appointments.index')->with('status', "{$importados} compromisso(s) importado(s).");
    }

    private function extrairCampoIcs(string $bloco, string $campo): ?string
    {
        if (preg_match('/^' . $campo . '(?:;[^:]*)?:(.*)$/mi', $bloco, $m)) {
            return trim(str_replace(['\\,', '\\;', '\\n'], [',', ';', ' '], $m[1]));
        }
        return null;
    }

    private function parseIcsData(string $valor): ?Carbon
    {
        $valor = trim($valor);
        try {
            if (str_contains($valor, 'T')) {
                return Carbon::createFromFormat('Ymd\THis', substr($valor, 0, 15));
            }
            return Carbon::createFromFormat('Ymd', substr($valor, 0, 8))->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }

    private function escapeIcs(string $texto): string
    {
        return str_replace([',', ';', "\n"], ['\,', '\;', '\\n'], $texto);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:reuniao,prazo,chamada,outro',
            'date' => 'required|date',
            'time_start' => 'nullable|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'recurrence' => 'nullable|in:nenhuma,diaria,semanal,mensal',
            'recurrence_until' => 'nullable|date',
        ]);
    }
}
