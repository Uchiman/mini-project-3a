<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->integer('penjualan_id')->constrained('penjualans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('barang_id')->constrained('barangs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('jumlah_barang');
            $table->integer('harga_jual')->nullable();;
            $table->integer('diskon')->nullable();
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
        Schema::dropIfExists('detail_penjualans');
    }
}
