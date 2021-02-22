<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);

        Role::create([
            'name' => 'pimpinan'
        ]);

        Role::create([
            'name' => 'kasir'
        ]);

        Role::create([
            'name' => 'staff'
        ]);
    }
}
