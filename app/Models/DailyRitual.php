<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRitual extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'started_at',
        'finished_at',
        'humor_saida',
        'observacoes',
    ];

    protected $casts = [
        'date' => 'date',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];
}
