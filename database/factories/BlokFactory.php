<?php

namespace Database\Factories;

use App\Models\Blok;
use App\Models\Gang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blok>
 */
class BlokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gang_id' => Gang::factory(),
            'nama_blok' => 'Blok '.fake()->randomElement(['A', 'B', 'C', 'D']),
            'nomor_rumah' => sprintf('%02d', fake()->numberBetween(1, 50)),
            'keterangan' => 'Rumah tinggal keluarga',
        ];
    }
}
