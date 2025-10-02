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
        Schema::create('haiss', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('q1');
            $table->string('q2');
            $table->string('q3');
            $table->string('q4');
            $table->string('q5');
            $table->string('q6');
            $table->string('q7');
            $table->string('q8');
            $table->string('q9');
            $table->string('q10');
            $table->string('q11');
            $table->string('q12');
            $table->string('q13');
            $table->string('q14');
            $table->string('q15');
            $table->string('q16');
            $table->string('q17');
            $table->string('q18');
            $table->string('q19');
            $table->string('q20');
            $table->string('q21');
            $table->string('q22');
            $table->string('q23');
            $table->string('q24');
            $table->string('q25');
            $table->string('q26');
            $table->string('q27');
            $table->string('q28');
            $table->string('q29');
            $table->string('q30');
            $table->string('q31');
            $table->string('q32');
            $table->string('q33');
            $table->string('q34');
            $table->string('q35');
            $table->string('q36');
            $table->string('q37');
            $table->string('q38');
            $table->string('q39');
            $table->string('q40');
            $table->string('q41');
            $table->string('q42');
            $table->string('q43');
            $table->string('q44');
            $table->string('q45');
            $table->string('q46');
            $table->string('q47');
            $table->string('q48');
            $table->string('q49');
            $table->string('q50');
            $table->string('q51');
            $table->string('q52');
            $table->string('q53');
            $table->string('q54');
            $table->string('q55');
            $table->string('q56');
            $table->string('q57');
            $table->string('q58');
            $table->string('q59');
            $table->string('q60');
            $table->string('q61');
            $table->string('q62');
            $table->string('q63');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('haiss');
    }
};