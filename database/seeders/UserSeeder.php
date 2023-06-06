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
        // Make seeder for user
        // User::create([
        //     'username' => 'ruangbougenville',
        //     'password' => Hash::make('rb12345'),
        // ]);

        // User::create([
        //     'username' => 'ruanganggrek',
        //     'password' => Hash::make('ra12345'),
        // ]);

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin12345'),
        ]);

    }
}
