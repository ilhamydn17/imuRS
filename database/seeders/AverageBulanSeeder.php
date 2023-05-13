<?php

namespace Database\Seeders;

use App\Models\AverageBulan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class AverageBulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AverageBulan::factory()->count(12)->create();
    }
}
