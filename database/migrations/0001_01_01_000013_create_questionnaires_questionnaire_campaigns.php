<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('questionnaires_questionnaires_campaigns', function (Blueprint $table) {           
            $table->id();
            $table->foreignId('q_id')->constrained('questionnaires')->onDelete('cascade');
            $table->foreignId('q_c_id')->constrained('questionnaires_campaigns')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('questionnaires_questionnaires_campaigns');
    }
};
