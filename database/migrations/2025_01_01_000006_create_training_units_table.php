<?php
// Realizzato da: Cosimo Mandrillo

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('training_campaigns')->cascadeOnDelete();
            $table->enum('content_type', ['text', 'audio']);
            $table->text('content_body');
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_units');
    }
};
