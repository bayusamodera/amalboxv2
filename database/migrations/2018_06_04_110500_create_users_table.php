<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 33)->unique();
            $table->string('password')->nullable();
            $table->string('phone_number', 15);
            $table->string('name', 33);
            $table->text('profile_picture')->nullable();
            $table->unsignedInteger('idx_user_type_id');
            $table->foreign('idx_user_type_id')->references('id')->on('idx_user_type');
            $table->boolean('status');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
