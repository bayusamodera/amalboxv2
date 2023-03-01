<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('idx_location', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('idx_program_category', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('idx_user_type', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('invoice', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('program_donatur', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('program_info', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('program_profile', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
