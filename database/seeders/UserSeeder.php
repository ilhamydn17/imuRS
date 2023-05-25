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
        User::create([
            'username'=>'instalasigawatdarurat',
        'password'=>Hash::make('password'),
        ]);

        User::create([
            'username'=>'ruanganggrek',
            'password'=>Hash::make('password'),
        ]);

        // User::create([
        //     'unit_id'=>3,
        //     'username'=>'instalasigawatdarurat',
        //     'password'=>Hash::make('password'),
        // ]);

        // User::created([
        //     'unit_id'=>4,
        //     'username'=>'poligigi',
        //     'password'=>Hash::make('password'),
        // ]);
    }
}

/*
 [

            ],
            [

            ],
            [

            ],
*/
