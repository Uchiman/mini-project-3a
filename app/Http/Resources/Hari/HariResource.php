<?php

namespace App\Http\Resources\Hari;

use Illuminate\Http\Resources\Json\JsonResource;

class HariResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'tanggal'          => $this->hari,
            'nama'             => $this->created_at->format('l, d-M-Y'),
        ];
    }
}
