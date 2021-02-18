<?php

namespace App\Http\Resources\Barang;

use Illuminate\Http\Resources\Json\JsonResource;

class BarangResource extends JsonResource
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
            'id'            => $this->id,
            'nama'          => $this->nama,
            'kode'          => $this->kode,
            'harga_beli'    => number_format($this->harga_beli, 0, ',', '.'),
            'harga_jual'    => number_format($this->harga_jual, 0, ',', '.'),
            'kategori_id'   => $this->kategori->id,
            'kategori'      => $this->kategori->nama,
            'merek'         => $this->merek,
            'stok'          => $this->stok,
            'diskon'        => $this->diskon,
        ];
    }
}
