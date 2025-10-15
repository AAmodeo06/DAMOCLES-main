<?php

//REALIZZATO DA: Andrea Amodeo

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_human_factor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('human_factor_id')->constrained('human_factors')->cascadeOnDelete();
            $table->enum('debt_level', ['none','low','medium','high','max'])->default('none');
            $table->timestamps();

            $table->unique(['user_id', 'human_factor_id']); // Evita duplicati
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_human_factor');
    }
};
