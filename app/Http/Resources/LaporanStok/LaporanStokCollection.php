<?php

namespace App\Http\Resources\LaporanStok;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LaporanStokCollection extends ResourceCollection
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
            'data' => LaporanStokResource::collection($this->collection),
        ];
    }
}
