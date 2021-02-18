<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
