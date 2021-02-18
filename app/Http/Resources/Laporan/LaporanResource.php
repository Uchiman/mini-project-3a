<?php

namespace App\Http\Resources\Laporan;

use Illuminate\Http\Resources\Json\JsonResource;

class LaporanResource extends JsonResource
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
            'id'                => $this->id,
            'pemasukan'         => number_format($this->total_pemasukan, 0, ',', '.'),
            'pengeluaran'       => number_format($this->total_pengeluaran, 0, ',', '.'),
            'hasil'             => number_format($this->hasil, 0, ',', '.'),
            'tanggal'           => $this->hari,
        ];
    }
}
