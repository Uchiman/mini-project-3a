<?php

namespace App\Http\Resources\Absen;

use App\Absen;
use App\KodeAbsen;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = explode('-', $this->created_at);
        $year = $date[0];
        $month = $date[1];
        $dataAbsen = KodeAbsen::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $totalAbsen = count($dataAbsen);
        
        return [
            'id'                => $this->id,
            'nama'              => $this->user->name, 
            'presentase_absen'  => $this->absen * 100 / $totalAbsen,
        ];
    }
}
