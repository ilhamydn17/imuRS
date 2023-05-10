<?php

namespace Database\Seeders;

use App\Models\TestingModel;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TestingModel::create([
        //     'nama_data' => 'data1',
        // ]);

        TestingModel::create([
            'nama_data' => 'data kedua cuy',
        ]);
    }
}
