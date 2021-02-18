<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function laporanStok()
    {
        return $this->hasMany(laporanStok::class);
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }
}
