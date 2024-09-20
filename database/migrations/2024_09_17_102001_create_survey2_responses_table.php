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
        Schema::create('survey2_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_submission_id');
            $table->integer('question_index'); // Question index (0 for first question, 1 for second, etc.)
            $table->string('response'); // Store the response (0-10 or NA)
            $table->timestamps();

            $table->foreign('user_submission_id')->references('id')->on('user_submissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey2_responses');
    }
};
