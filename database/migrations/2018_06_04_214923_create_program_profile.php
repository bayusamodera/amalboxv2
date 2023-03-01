<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('idx_program_category_id');
            $table->foreign('idx_program_category_id')->references('id')->on('idx_program_category');
            $table->string('title', 50);
            $table->longtext('detail');
            $table->bigInteger('target_donation');
            $table->text('location');
            // $table->unsignedInteger('idx_location_id');
            // $table->foreign('idx_location_id')->references('id')->on('idx_location');
            $table->boolean('status');
            $table->date('date_end');
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
        Schema::dropIfExists('program_profile');
    }
}
