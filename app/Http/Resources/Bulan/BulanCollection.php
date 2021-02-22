<?php

namespace App\Http\Resources\Bulan;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BulanCollection extends ResourceCollection
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
            'data' => BulanResource::collection($this->collection),
        ];
    }
}
