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
            'user_id' => 1,
            'nama_unit' => 'R. Bougenville',
        ]);

        Unit::create([
            'user_id' => 2,
            'nama_unit' => 'R. Anggrek',
        ]);

        Unit::create([
            'user_id' => 3,
            'nama_unit' => 'IGD',
        ]);

        // Unit::create([
        //     'user_id' => 4,
        //     'nama_unit' => 'OK',
        // ]);

        // Unit::create([
        //     'user_id' => 5,
        //     'nama_unit' => 'ICU',
        // ]);

        // Unit::create([s
        //     'user_id' => 6,
        //     'nama_unit' => 'P.Bedah',
        // ]);

        // Unit::create([
        //     'user_id' => 7,
        //     'nama_unit' => 'P.IPD',
        // ]);

        // Unit::create([
        //     'user_id' => 8,
        //     'nama_unit' => 'P.Obsgyn',
        // ]);

        // Unit::create([
        //     'user_id' => 9,
        //     'nama_unit' => 'P.Anak',
        // ]);

        // Unit::create([
        //     'user_id' => 10,
        //     'nama_unit' => 'P.Paru',
        // ]);

        // Unit::create([
        //     'user_id' => 11,
        //     'nama_unit' => 'P.Gigi',
        // ]);

        // Unit::create([
        //     'user_id' => 12,
        //     'nama_unit' => 'P.Rehab Medis',
        // ]);

        // Unit::create([
        //     'user_id' => 13,
        //     'nama_unit'=>'P.Mata',
        // ]);

        // Unit::create([
        //     'user_id' => 14,
        //     'nama_unit' => 'P.Orto',
        // ]);

        // Unit::create([
        //     'user_id' => 15,
        //     'nama_unit' => 'P.Syaraf',
        // ]);

        // Unit::create([
        //     'user_id' => 16,
        //     'nama_unit' => 'P.KB',
        // ]);

        // Unit::create([
        //     'user_id' => 17,
        //     'nama_unit' => 'Gizi',
        // ]);

        // Unit::create([
        //     'user_id' => 18,
        //     'nama_unit' => 'RM',
        // ]);

        // Unit::create([
        //     'user_id' => 19,
        //     'nama_unit' => 'IT',
        // ]);

        // Unit::create([
        //     'user_id' => 20,
        //     'nama_unit' => 'Lab',
        // ]);

        // Unit::create([
        //     'user_id' => 21,
        //     'nama_unit' => 'Radiologi',
        // ]);

        // Unit::create([
        //     'user_id' => 22,
        //     'nama_unit' => 'Farmasi',
        // ]);

        // Unit::create([
        //     'user_id' => 23,
        //     'nama_unit' => 'Dukkes',
        // ]);

        // Unit::create([
        //     'user_id' => 24,
        //     'nama_unit' => 'Laundry',
        // ]);

        // Unit::create([
        //     'user_id' => 25,
        //     'nama_unit' => 'Sterilisasi',
        // ]);

        // Unit::create([
        //     'user_id' => 26,
        //     'nama_unit' => 'K.Jenazah',
        // ]);

        // Unit::create([
        //     'user_id' => 27,
        //     'nama_unit' => 'TAUD',
        // ]);

        // Unit::create([
        //     'user_id' => 28,
        //     'nama_unit' => 'MINMED',
        // ]);

        // Unit::create([
        //     'user_id' => 29,
        //     'nama_unit' => 'Ambulan',
        // ]);

        // Unit::create([
        //     'user_id' => 30,
        //     'nama_unit' => 'BPJS',
        // ]);

        // Unit::create([
        //     'user_id' => 31,
        //     'nama_unit' => 'IPSRS',
        // ]);

        // Unit::create([
        //     'user_id' => 32,
        //     'nama_unit' => 'Pengadaan',
        // ]);

        // Unit::create([
        //     'user_id' => 33,
        //     'nama_unit' => 'Bendahara',
        // ]);

    }
}
