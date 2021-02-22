<?php

namespace App\Http\Resources\Hari;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HariCollection extends ResourceCollection
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
            'data' => HariResource::collection($this->collection),
        ];
    }
}
