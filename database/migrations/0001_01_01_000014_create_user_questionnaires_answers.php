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
        Schema::create('user_questionnaires_answers', function (Blueprint $table) {           
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('q_id')->constrained('questionnaires')->onDelete('cascade');
            $table->foreignId('q_c_id')->constrained('questionnaires_campaigns')->onDelete('cascade');
            $table->foreignId('answer_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_questionnaires_answers');
    }
};
