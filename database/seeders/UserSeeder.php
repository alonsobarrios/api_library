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
        User::factory(15)->create();

        User::create([
            'name' => 'Alonso Barrios',
            'email' => 'alonsobarrios@test.com',
            'phone' => '3003103200',
            'password' => Hash::make('Admin123!'),
        ]);
    }
}
