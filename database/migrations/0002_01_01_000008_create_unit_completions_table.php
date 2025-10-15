<?php

//REALIZZATO DA: Luigi La Gioia

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unit_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('training_assignments')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('training_units')->cascadeOnDelete();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['assignment_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_completions');
    }
};
