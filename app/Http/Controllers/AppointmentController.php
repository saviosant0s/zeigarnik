<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    public function index(Request $request): View
    {
        $referencia = $request->has('semana')
            ? Carbon::parse($request->query('semana'))
            : today();

        $inicio = $referencia->copy()->startOfWeek();
        $fim = $referencia->copy()->endOfWeek();

        $appointments = Appointment::daSemana($inicio, $fim)
            ->orderBy('date')
            ->orderBy('time_start')
            ->get()
            ->groupBy(fn ($a) => $a->date->toDateString());

        $dias = collect(range(0, 6))->map(fn ($i) => $inicio->copy()->addDays($i));

        return view('appointments.index', [
            'appointments' => $appointments,
            'dias' => $dias,
            'inicio' => $inicio,
            'fim' => $fim,
        ]);
    }

    public function create(): View
    {
        return view('appointments.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        Appointment::create($data);

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

    public function toggleDone(Appointment $appointment): RedirectResponse
    {
        $appointment->update(['done' => ! $appointment->done]);

        return back();
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
        ]);
    }
}
