<?php

namespace App\Http\Resources\DetailPenjualan;

use App\Barang;
use App\Penjualan;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailPenjualanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $barang = Barang::where('id', $this->barang_id)->first();
        $penjualan = Penjualan::where('id', $this->penjualan_id)->first();
        if ($penjualan->kode_member) {
            return [
                'id'                => $this->id,
                'barang'            => $this->barang->nama,
                'jumlah_barang'     => $this->jumlah_barang,
                'harga_satuan'      => number_format($barang->harga_jual, 0, ',', '.'),
                'harga'             => number_format($this->harga_jual, 0, ',', '.'),
                'diskon'            => $this->diskon,
            ];
        }
        return [
            'id'                => $this->id,
            'barang'            => $this->barang->nama,
            'jumlah_barang'     => $this->jumlah_barang,
            'harga_satuan'      => number_format($barang->harga_jual, 0, ',', '.'),
            'harga'             => number_format($this->harga_jual, 0, ',', '.'),
        ];
    }
}
