<?php

namespace Database\Seeders;

use App\Models\PengukuranMutu;
use Illuminate\Database\Seeder;

class PengukuranMutuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Call PengukuranMutuFactory
        PengukuranMutu::factory()->count(30)->create();
    }
}
