<?php

namespace Database\Factories;

use App\Models\Gang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gang>
 */
class GangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bunga = fake()->randomElement([
            'Melati',
            'Mawar',
            'Anggrek',
            'Cempaka',
            'Flamboyan',
            'Kamboja',
            'Kenanga',
            'Dahlia',
            'Bougenville',
            'Teratai',
        ]);

        $namaGang = 'Gang '.$bunga.' '.fake()->unique()->numberBetween(1, 9999);

        return [
            'nama_gang' => $namaGang,
            'keterangan' => 'Area lingkungan '.$namaGang,
        ];
    }
}
