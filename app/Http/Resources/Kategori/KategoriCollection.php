<?php

namespace App\Http\Resources\Kategori;

use Illuminate\Http\Resources\Json\ResourceCollection;

class KategoriCollection extends ResourceCollection
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
            'data' => KategoriResource::collection($this->collection),
        ];
    }
}
