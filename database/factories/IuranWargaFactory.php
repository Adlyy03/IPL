<?php

namespace Database\Factories;

use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IuranWarga>
 */
class IuranWargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['menunggu_pembayaran', 'lunas']);

        return [
            'warga_id' => Warga::factory(),
            'jenis_iuran_id' => JenisIuran::factory(),
            'periode' => now()->format('Y-m'),
            'nominal' => fake()->randomElement([25000, 35000, 20000, 50000]),
            'status_pembayaran' => $status,
            'tanggal_pembayaran' => $status === 'lunas' ? now()->subDays(fake()->numberBetween(1, 10)) : null,
            'catatan' => $status === 'lunas' ? 'Lunas via transfer bank' : 'Tagihan periode berjalan',
        ];
    }
}
