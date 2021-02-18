<?php

namespace App\Http\Resources\Barang;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BarangCollection extends ResourceCollection
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
            'data' => BarangResource::collection($this->collection),
        ];
    }
}
