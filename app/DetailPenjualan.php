<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
