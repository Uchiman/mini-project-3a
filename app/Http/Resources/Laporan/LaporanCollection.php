<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LaporanCollection extends ResourceCollection
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
            'data' => LaporanResource::collection($this->collection),
        ];
    }
}
