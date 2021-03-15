<?php

use App\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'nama'    =>  'Default',
        ]);

        Supplier::create([
            'nama'    =>  'Toko Agung',
            'alamat'    =>  'Bantul',
        ]);
    }
}
