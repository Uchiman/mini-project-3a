<?php

use App\Kasir;
use Illuminate\Database\Seeder;

class KasirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kasir::create([
            'umur'    =>  '20',
            'alamat'    =>  'Sleman',
            'user_id'    =>  '3',
        ]);
    }
}
