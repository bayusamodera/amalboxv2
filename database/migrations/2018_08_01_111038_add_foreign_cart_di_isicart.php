<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignCartDiIsicart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('isi_cart', function (Blueprint $table) {            
            $table->unsignedInteger('cart_id');
            $table->foreign('cart_id')->references('id')->on('cart')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('isi_cart', function (Blueprint $table) {
            //
        });
    }
}
