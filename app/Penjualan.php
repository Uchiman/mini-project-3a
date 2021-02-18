<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    public function kasir()
    {
        return $this->belongsTo(Kasir::class);
    }
}
