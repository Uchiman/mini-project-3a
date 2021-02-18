<?php

namespace App\Http\Resources\Penjualan;

use App\Http\Resources\DetailPenjualan\DetailPenjualanCollection;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $kasir = User::where('id', $this->kasir_id)->first();
        return [
            'id'                   => $this->id,
            'kasir'                => $kasir->name,
            'total_harga'          => number_format($this->total_bayar, 0, ',', '.'),
            'dibayar'              => number_format($this->dibayar, 0, ',', '.'),
            'kembalian'            => number_format($this->kembalian, 0, ',', '.'),
            'tanggal'              => $this->created_at->format('d-M-Y'),
            'jam'                  => $this->created_at->format('h:i a'),
        ];
    }
}
