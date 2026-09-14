<?php

namespace App\Http\Controllers;

use App\Models\DailyRitual;
use App\Models\LoopEntry;
use Illuminate\View\View;

class CheckinController extends Controller
{
    public function index(): View
    {
        $ontem = today()->subDay()->toDateString();

        $ritualOntem = DailyRitual::where('date', $ontem)->first();

        $entriesOntem = LoopEntry::with('task')
            ->where('date', $ontem)
            ->get();

        return view('checkin', [
            'ritualOntem' => $ritualOntem,
            'entriesOntem' => $entriesOntem,
        ]);
    }
}
