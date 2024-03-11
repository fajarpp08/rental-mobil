<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Fajar Admin',
            'alamat' => 'Padang',
            'nosim' => '00111',
            'nohp' => '081218173646',
            'password' => Hash::make('123'),
            'role' => 'Admin',
        ]);
        User::create([
            'nama' => 'Fajar User',
            'alamat' => 'Bandung',
            'nosim' => '00222',
            'nohp' => '081213141516',
            'password' => Hash::make('123'),
            'role' => 'User',
        ]);
    }
}
