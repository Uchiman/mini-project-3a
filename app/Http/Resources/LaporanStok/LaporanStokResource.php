<?php

namespace App\Http\Resources\LaporanStok;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanStokResource extends JsonResource
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
            'id'               => $this->id,
            'barang'           => $this->barang->nama,
            'barang_masuk'     => $this->barang_masuk,
            'barang_terjual'   => $this->terjual,
            'sisa_barang'      => $this->sisa,
            'tanggal'          => $this->hari,
        ];
    }
}
