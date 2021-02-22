<?php

namespace App\Http\Resources\Absen;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AbsenCollection extends ResourceCollection
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
            'data' => AbsenResource::collection($this->collection),
        ];
    }
}
