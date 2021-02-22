<?php

namespace App\Http\Resources\Pengeluaran;

use Illuminate\Http\Resources\Json\JsonResource;

class PengeluaranResource extends JsonResource
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
            'id'              => $this->id,
            'keterangan'      => $this->keterangan,
            'biaya'           => number_format($this->biaya, 0, ',', '.'),
            'hari'            => $this->hari,
            'bulan'           => $this->bulan,

        ];
    }
}
