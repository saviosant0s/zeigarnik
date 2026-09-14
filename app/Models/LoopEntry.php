<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoopEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'date',
        'onde_parei',
        'proxima_acao',
        'encerrado_em',
    ];

    protected $casts = [
        'date' => 'date',
        'encerrado_em' => 'datetime',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
