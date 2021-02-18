<?php

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'nama' => $this->nama,
            'no_hp' => $this->no_hp,
            'kode_member' => $this->kode_member,
            'saldo' => number_format($this->saldo, 0, ',', '.'),
            'tanggal_pembuatan' => $this->created_at->format('l, d-m-Y'),
            
    ];
    }
}
