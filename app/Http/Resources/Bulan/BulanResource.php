<?php

namespace App\Http\Resources\Bulan;

use Illuminate\Http\Resources\Json\JsonResource;

class BulanResource extends JsonResource
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
            'id'             => $this->id,
            'bulan'          => $this->bulan,
            'nama'           => $this->created_at->format('F-Y'),
        ];
    }
}
