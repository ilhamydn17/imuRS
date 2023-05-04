<?php

namespace Database\Seeders;

use App\Models\IndikatorMutu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndikatorMutuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndikatorMutu::create(
            [
            'unit_id'=>2,
            'nama_indikator'=>' KEPATUHAN CLINICAL PATHWAY',
            'nama_numerator'=>'Jumlah pelayanan sesuai CP',
            'nama_denumerator'=>'Jumlah pelayanan pada CP yang diobservasi'
            ],
        );

        IndikatorMutu::create(
            [
            'unit_id'=>2,
            'nama_indikator'=>'KEJADIAN PHLEBITIS',
            'nama_numerator'=>'Jumlah pasien yang mengalami phlebitis',
            'nama_denumerator'=>'Jumlah pasien yang terpasang IV line'
            ],
        );
    }
}
