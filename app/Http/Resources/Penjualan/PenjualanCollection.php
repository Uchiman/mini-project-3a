<?php

namespace App\Http\Resources\Penjualan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PenjualanCollection extends ResourceCollection
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
            'data' => PenjualanResource::collection($this->collection),
        ];
    }
}
