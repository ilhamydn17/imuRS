<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    public $model = Unit::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Unit::create([
            'nama_unit' => 'IT RSAU',
        ]);

    }
}
