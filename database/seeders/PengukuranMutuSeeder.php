<?php

namespace Database\Seeders;

use App\Models\PengukuranMutu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Ramsey\Uuid\Type\Decimal;

class PengukuranMutuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    //    call pengukuranFacktory
    PengukuranMutu::factory()->count(30)->create();
    }
}
