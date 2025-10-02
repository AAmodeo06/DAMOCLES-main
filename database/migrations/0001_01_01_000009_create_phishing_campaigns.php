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
        Schema::create('phishing_campaigns', function (Blueprint $table) {           
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->integer('numberEmails');
            $table->foreignId('context_id')->constrained('phishing_contexts')->onDelete('cascade');
            $table->json('emotionalTriggers')->nullable();
            $table->json('persuasions')->nullable();
            $table->foreignId('llm_id')->constrained('llms')->onDelete('cascade');
            $table->text('prompt');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade');
            $table->enum('state',['Draft','Ready','Ongoing', 'Finished'])->default('Draft');
            $table->date('expirationDate');
            $table->integer('timingEmail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('phishing_campaigns');
    }
};
