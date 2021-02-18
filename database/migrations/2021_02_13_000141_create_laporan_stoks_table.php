<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanStoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_stoks', function (Blueprint $table) {
            $table->id();
            $table->integer('barang_id')->constrained('barang')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('barang_masuk')->default('0');
            $table->integer('terjual')->default('0');
            $table->integer('sisa')->default('0');
            $table->string('hari');
            $table->string('bulan');
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
        Schema::dropIfExists('laporan_stoks');
    }
}
