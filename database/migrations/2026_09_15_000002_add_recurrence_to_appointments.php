<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->enum('recurrence', ['nenhuma', 'diaria', 'semanal', 'mensal'])->default('nenhuma')->after('reminder_at');
            $table->date('recurrence_until')->nullable()->after('recurrence');
            $table->string('recurrence_group')->nullable()->after('recurrence_until'); // agrupa as ocorrências geradas juntas
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['recurrence', 'recurrence_until', 'recurrence_group']);
        });
    }
};
