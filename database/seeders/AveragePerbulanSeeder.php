<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AveragePerbulan;
use Carbon\Carbon;

class AveragePerbulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AveragePerbulan::create([
            'tanggal' => Carbon::now()->format('Y-m'),
            'avg_value' => 1.5,
        ]);
    }
}
