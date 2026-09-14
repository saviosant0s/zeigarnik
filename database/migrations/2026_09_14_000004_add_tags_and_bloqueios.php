<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('tags')->nullable()->after('type');
        });

        Schema::table('loop_entries', function (Blueprint $table) {
            $table->text('bloqueios')->nullable()->after('proxima_acao');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('tags');
        });

        Schema::table('loop_entries', function (Blueprint $table) {
            $table->dropColumn('bloqueios');
        });
    }
};
