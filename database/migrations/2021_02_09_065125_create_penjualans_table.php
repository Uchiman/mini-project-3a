<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->integer('dibayar')->nullable();
            $table->integer('kembalian')->nullable();
            $table->integer('total_bayar')->nullable();
            $table->string('kode_member')->nullable();
            $table->integer('kasir_id')->constrained('kasirs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('status')->default('0');
            $table->string('hari')->nullable();
            $table->string('bulan')->nullable();
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
        Schema::dropIfExists('penjualans');
    }
}
