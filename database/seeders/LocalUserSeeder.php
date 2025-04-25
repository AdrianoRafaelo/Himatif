<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocalUser;
use Illuminate\Support\Facades\Hash;

class LocalUserSeeder extends Seeder
{
    public function run()
    {
        LocalUser::create([
            'username' => 'adminlocal',
            'nama' => 'Admin Lokal',
            'password' => Hash::make('admin12345'), // password harus di-hash!
            'role' => 'admin',
            'nim' => null,
            'angkatan' => null,
            'prodi' => null,
        ]);

        LocalUser::create([
            'username' => 'bendahara1',
            'nama' => 'Bendahara Contoh',
            'password' => Hash::make('bendahara123'),
            'role' => 'bendahara',
            'nim' => null,
            'angkatan' => null,
            'prodi' => null,
        ]);
    }
}
