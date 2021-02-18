<?php

namespace App\Http\Resources\Pembelian;

use Illuminate\Http\Resources\Json\JsonResource;

class PembelianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'supplier'              => $this->supplier,
            'barang'                => $this->barang,
            'total_barang'          => $this->total_barang,
            'total_bayar'           => number_format($this->total_bayar, 0, ',', '.'),
            'tanggal_pembelian'     => $this->created_at->format('d-M-Y'),
            'hari_pembelian'        => $this->created_at->format('l'),
        ];
    }
}
