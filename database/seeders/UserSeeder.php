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
        //make seeder for user
        User::create([
            'unit_id'=>2,
            'username'=>'ruangangggrek',
            'password'=>Hash::make('password'),
        ]);

        User::create([
            'unit_id'=>3,
            'username'=>'instalasigawatdarurat',
            'password'=>Hash::make('password'),
        ]);
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
