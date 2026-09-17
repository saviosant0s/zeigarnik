<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRead extends Model
{
    protected $fillable = [
        'article_slug',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];
}
