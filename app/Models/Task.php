<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'status',
        'tags',
    ];

    public function loopEntries(): HasMany
    {
        return $this->hasMany(LoopEntry::class);
    }

    public function latestLoopEntry()
    {
        return $this->hasOne(LoopEntry::class)->latestOfMany('date');
    }

    public function scopeAbertas($query)
    {
        return $query->where('status', 'aberta');
    }
}
