<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin DJM',
            'username' => 'admin_djm',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Dian Mardani',
            'username' => 'dianmrd',
            'email' => 'dian@example.com',
            'password' => Hash::make('dian123'),
            'role' => 'user'
        ]);

        $namaRandom = ['Algrecia Luz', 'Dewi Santika', 'Asep Maulana', 'Iyan Setiana', 'Refa', 'Wulan', 'Dain Permana', 'Hilman', 'Dicky Andrean', 'Ciko'];

        foreach ($namaRandom as $nama) {
            $slugName = strtolower(str_replace(' ', '', $nama));
            User::factory()->create([
                'name' => $nama,
                'username' => $slugName,
                'email' => $slugName . '@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]);
        }
    }
}
