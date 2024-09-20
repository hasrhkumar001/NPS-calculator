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
            $table->unsignedBigInteger('user_id')->nullable();  // In case you want to associate with a logged-in user
            $table->string('idsGroup');
            $table->string('projectName');
            $table->string('csatOccurrence');
            $table->string('idsLeadManager');
            $table->string('clientOrganization');
            $table->string('clientContactName');
            $table->string('clientEmailAddress');
            $table->timestamps();

            // Ensure user_id is unique (so the user can only submit once)
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_submissions');
    }
};
