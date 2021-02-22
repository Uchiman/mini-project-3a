<?php

namespace App\Http\Resources\DetailPenjualan;

use App\DetailPenjualan;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DetailPenjualanCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dataTerakhir = DetailPenjualan::latest()->first();
        $total_bayar = DetailPenjualan::where('penjualan_id', $dataTerakhir->penjualan_id)->sum('harga_jual');
        return [
            'status' => 'success',
            'message' => 'data berhasil ditampilkan',
            'data' => DetailPenjualanResource::collection($this->collection),
            'total_bayar' => $total_bayar,
        ];
    }
}
