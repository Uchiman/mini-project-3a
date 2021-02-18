<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'kode' => null,
        ]);
        $admin->assignRole('admin');

        $pimpinan = User::create([
            'name' => 'Buzz Lightyear',
            'email' => 'pimpinan@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'kode' => null,
        ]);
        $pimpinan->assignRole('pimpinan');

        $kasir = User::create([
            'name' => 'Jessica Jessie',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'kode' => null,
        ]);
        $kasir->assignRole('kasir');

        $staff = User::create([
            'name' => 'Sheriff Woody Pride',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'kode' => null,
        ]);
        $staff->assignRole('staff');

        $member = User::create([
            'name' => 'Usman Khabilah',
            'email' => 'utsman.khabillah@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => null,
            'kode' => null,
        ]);
        $member->assignRole('member');

        $member = User::create([
            'name' => 'Nabil Aramiko',
            'email' => 'aramik.saja@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => null,
            'kode' => null,
        ]);
        $member->assignRole('member');
    }
}
