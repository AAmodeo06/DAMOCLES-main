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
        Schema::create('users_phishing_emails', function (Blueprint $table) {           
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('email_id')->constrained('phishing_emails_phishing_campaigns')->onDelete('cascade');
            $table->dateTime('sent')->nullable();
            $table->dateTime('opened')->nullable();
            $table->dateTime('clicked')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users_phishing_emails');
    }
};
