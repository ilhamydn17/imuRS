<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengukuranMutu>
 */
class PengukuranMutuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = \App\Models\PengukuranMutu::class;

    public function definition(): array
    {
        static $tanggal = 1;

        return [
            'indikator_mutu_id' => 1,
            'numerator'=>$this->faker->numberBetween(1, 10),
            'denumerator'=>$this->faker->numberBetween(1, 10),
            'tanggal_input' => now()->setDays($tanggal++)->setMonth(5)->setYear(2023),
            'prosentase'=> $this->faker->randomFloat(2, 60, 100)
        ];
    }
}
