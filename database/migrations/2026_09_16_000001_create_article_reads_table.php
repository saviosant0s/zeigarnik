<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_reads', function (Blueprint $table) {
            $table->id();
            $table->string('article_slug')->unique();
            $table->timestamp('read_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_reads');
    }
};
