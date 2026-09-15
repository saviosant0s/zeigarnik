<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'date',
        'time_start',
        'time_end',
        'location',
        'notes',
        'reminder_at',
        'done',
        'recurrence',
        'recurrence_until',
        'recurrence_group',
    ];

    protected $casts = [
        'date' => 'date',
        'reminder_at' => 'datetime',
        'recurrence_until' => 'date',
        'done' => 'boolean',
    ];

    public function scopeDoDia($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeDaSemana($query, $inicio, $fim)
    {
        return $query->whereBetween('date', [$inicio, $fim]);
    }
}
