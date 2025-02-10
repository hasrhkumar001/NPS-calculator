<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
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
            $table->string('Q16')->nullable();
            $table->string('Q17')->nullable();
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('ids_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
