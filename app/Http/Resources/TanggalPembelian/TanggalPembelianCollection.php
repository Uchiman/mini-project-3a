<?php

namespace App\Http\Resources\TanggalPembelian;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TanggalPembelianCollection extends ResourceCollection
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
            'status' => 'success',
            'message' => 'data berhasil ditampilkan',
            'data' => TanggalPembelianResource::collection($this->collection),
        ];
    }
}
