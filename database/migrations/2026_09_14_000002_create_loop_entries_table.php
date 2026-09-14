<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loop_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->text('onde_parei');
            $table->text('proxima_acao');
            $table->timestamp('encerrado_em')->nullable();
            $table->timestamps();

            // Uma tarefa pode ter no máximo 1 registro de encerramento por dia
            $table->unique(['task_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loop_entries');
    }
};
