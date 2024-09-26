<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable(); // Foreign key to clients table
            $table->string('idsGroup');
            $table->string('projectName');
            $table->string('csatOccurrence');
            $table->string('idsLeadManager');
            $table->string('clientOrganization');
            $table->string('clientContactName');
            $table->string('clientEmailAddress');
            $table->string('status')->default('pending'); // Add status column with default 'pending'
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null'); // Assuming there's a clients table  // In case you want to associate with a logged-in user
            // Ensure user_id is unique (so the user can only submit once)
            $table->unique('client_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_submissions');
    }
};
