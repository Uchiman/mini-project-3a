<?php

use App\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'nama'    =>  'Makanan',
        ]);


        Kategori::create([
            'nama'    =>  'Minuman',
        ]);

        Kategori::create([
            'nama'    =>  'Perawatan Tubuh',
        ]);
    }
}
