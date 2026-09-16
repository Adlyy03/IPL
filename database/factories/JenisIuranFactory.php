<?php

namespace Database\Factories;

use App\Models\JenisIuran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisIuran>
 */
class JenisIuranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaIuran = fake()->randomElement([
            'Iuran Kebersihan',
            'Iuran Keamanan',
            'Iuran Perawatan Lingkungan',
            'Iuran Dana Sosial',
            'Iuran Kas RT',
            'Iuran Kegiatan Warga',
        ]).' '.fake()->unique()->numberBetween(1, 9999);

        return [
            'nama_iuran' => $namaIuran,
            'nominal' => fake()->randomElement([15000, 20000, 25000, 35000, 50000]),
            'deskripsi' => 'Pengelolaan '.$namaIuran,
            'is_aktif' => true,
        ];
    }
}
