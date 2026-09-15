<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->text('mail_password')->nullable(); // guardado encriptado (cast)
            $table->string('mail_encryption')->nullable(); // tls | ssl | null
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();
            $table->string('notify_email')->nullable(); // quem recebe os avisos
            $table->unsignedInteger('notify_minutes_before')->default(15);
            $table->boolean('notify_enabled')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
