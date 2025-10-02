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
        Schema::create('phishing_emails_phishing_campaigns', function (Blueprint $table) {           
            $table->id();
            $table->foreignId('phishing_campaign_id')->constrained('phishing_campaigns')->onDelete('cascade');
            $table->string('subject');
            $table->text('body');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('phishing_emails_phishing_campaigns');
    }
};
