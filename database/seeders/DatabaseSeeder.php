<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\IndikatorMutu;
use App\Models\PengukuranMutu;
use Illuminate\Database\Seeder;
use Database\Seeders\UnitSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // UnitSeeder::class,
        ]);
    }
}
