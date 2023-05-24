<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AveragePerbulan>
 */
class AveragePerbulanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public $model = \App\Models\AveragePerbulan::class;
    public function definition(): array
    {
        return [
            'tanggal' => '2021-01',
            'avg_value' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
