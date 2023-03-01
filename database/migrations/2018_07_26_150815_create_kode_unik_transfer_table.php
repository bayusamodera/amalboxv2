<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKodeUnikTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kode_unik_transfer', function (Blueprint $table) {
            $table->integer('value')->primary();
            $table->unsignedInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoice');
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
        Schema::dropIfExists('kode_unik_transfer');
    }
}
