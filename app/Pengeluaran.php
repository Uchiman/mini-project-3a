<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
