<?php

namespace App\Http\Resources\Pembelian;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PembelianCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 'Success',
            'message' => 'Data berhasil ditampilkan',
            'data' => PembelianResource::collection($this->collection),
        ];
    }
}
