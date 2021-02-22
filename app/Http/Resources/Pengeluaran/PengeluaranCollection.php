<?php

namespace App\Http\Resources\Pengeluaran;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PengeluaranCollection extends ResourceCollection
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
            'data' => PengeluaranResource::collection($this->collection),
        ];
    }
}
