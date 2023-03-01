<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramPicture extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_picture', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('program_profile_id');
            $table->foreign('program_profile_id')->references('id')->on('program_profile');
            $table->text('path');
            $table->text('detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('program_picture');
    }
}
