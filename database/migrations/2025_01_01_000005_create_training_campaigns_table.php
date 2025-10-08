<?php
// Realizzato da: Cosimo Mandrillo

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('attack_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->nullable()->constrained('prompt_templates')->nullOnDelete();
            $table->enum('training_type', ['text', 'audio', 'mixed']);
            $table->enum('status', ['draft', 'active', 'paused', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_campaigns');
    }
};
