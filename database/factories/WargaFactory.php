<?php

namespace Database\Factories;

use App\Models\Blok;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $daftarNama = [
            'Budi Santoso',
            'Siti Aminah',
            'Agus Setiawan',
            'Dewi Lestari',
            'Eko Prasetyo',
            'Rina Wijaya',
            'Bambang Haryanto',
            'Sri Wahyuni',
            'Hendro Susilo',
            'Nurul Hidayah',
            'Ahmad Fauzi',
            'Ratna Sari',
        ];

        return [
            'blok_id' => Blok::factory(),
            'nama_lengkap' => fake()->randomElement($daftarNama),
            'nik' => fake()->unique()->numerify('3201############'),
            'nomor_hp' => fake()->numerify('081#########'),
            'peran_keluarga' => fake()->randomElement(['kepala_keluarga', 'istri', 'anak']),
            'status_warga' => fake()->randomElement(['tetap', 'kontrak', 'kost']),
            'is_aktif' => true,
        ];
    }
}
