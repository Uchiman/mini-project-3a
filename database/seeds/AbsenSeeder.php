<?php

use App\Absen;
use App\KodeAbsen;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Absen::create([
            'user_id' => 3,
            'absen' => 0,
            'kode_id' => 1,
            'created_at' => Carbon::yesterday(),
        ]);

        Absen::create([
            'user_id' => 5,
            'absen' => 0,
            'kode_id' => 1,
            'created_at' => Carbon::yesterday(),
        ]);

        Absen::create([
            'user_id' => 6,
            'absen' => 0,
            'kode_id' => 1,
            'created_at' => Carbon::yesterday(),
        ]);

        KodeAbsen::create([
            'kode' => 00000,
            'created_at' => Carbon::yesterday(),
        ]);
    }
}
