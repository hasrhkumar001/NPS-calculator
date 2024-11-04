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
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->string('Q1')->nullable();
            $table->string('Q2')->nullable();
            $table->string('Q3')->nullable();
            $table->string('Q4')->nullable();
            $table->string('Q5')->nullable();
            $table->string('Q6')->nullable();
            $table->string('Q7')->nullable();
            $table->string('Q8')->nullable();
            $table->string('Q9')->nullable();
            $table->string('Q10')->nullable();
            $table->string('Q11')->nullable();
            $table->string('Q12')->nullable();
            $table->string('Q13')->nullable();
            $table->string('Q14')->nullable();
            $table->string('Q15')->nullable();
            $table->string('additional_comments')->default('No comments');
            $table->string('Neutral');
            $table->string('Promoter');
            $table->string('Detractor');
            $table->string('Neutral_percentage');
            $table->string('Promoter_percentage');
            $table->string('Detractor_percentage');
            $table->string('Nps_percentage');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
