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
        Schema::create('questionnaires_campaigns', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('title');
            $table->text('description');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->enum('state',['Draft','Ready','Ongoing', 'Finished'])->default('Draft');
            $table->date('expirationDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('questionnaires_campaigns');
    }
};