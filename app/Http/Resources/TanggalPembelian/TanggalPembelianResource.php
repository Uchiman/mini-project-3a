<?php

namespace App\Http\Resources\TanggalPembelian;

use Illuminate\Http\Resources\Json\JsonResource;

class TanggalPembelianResource extends JsonResource
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
            'id'                    => $this->id,
            'tanggal_pembelian'     => $this->hari,
            'hari_pembelian'        => $this->created_at->format('l'),
        ];
    }
}
