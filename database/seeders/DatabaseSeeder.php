<?php

namespace Database\Seeders;

use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\Warga;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Jalankan seeder database dengan urutan:
     * Gang -> Blok -> Warga -> Jenis Iuran -> Iuran Warga
     */
    public function run(): void
    {
        // 1. Seeder Gang
        $gangMelati = Gang::create([
            'nama_gang' => 'Gang Melati',
            'keterangan' => 'Area perumahan barat',
        ]);

        $gangMawar = Gang::create([
            'nama_gang' => 'Gang Mawar',
            'keterangan' => 'Area perumahan timur',
        ]);

        $gangAnggrek = Gang::create([
            'nama_gang' => 'Gang Anggrek',
            'keterangan' => 'Area perumahan utama',
        ]);

        // 2. Seeder Blok (Rumah)
        $blokA1 = Blok::create([
            'gang_id' => $gangMelati->id,
            'nama_blok' => 'Blok A',
            'nomor_rumah' => '01',
            'keterangan' => 'Rumah pojok / hook',
        ]);

        $blokA2 = Blok::create([
            'gang_id' => $gangMelati->id,
            'nama_blok' => 'Blok A',
            'nomor_rumah' => '02',
            'keterangan' => 'Rumah standar',
        ]);

        $blokB1 = Blok::create([
            'gang_id' => $gangMawar->id,
            'nama_blok' => 'Blok B',
            'nomor_rumah' => '01',
            'keterangan' => 'Rumah standar',
        ]);

        $blokB2 = Blok::create([
            'gang_id' => $gangMawar->id,
            'nama_blok' => 'Blok B',
            'nomor_rumah' => '02',
            'keterangan' => 'Rumah standar',
        ]);

        $blokC1 = Blok::create([
            'gang_id' => $gangAnggrek->id,
            'nama_blok' => 'Blok C',
            'nomor_rumah' => '01',
            'keterangan' => 'Dekat pos satpam',
        ]);

        // 3. Seeder Warga
        // Satu rumah (Blok A 01) dihuni lebih dari satu warga
        $wargaBudi = Warga::create([
            'blok_id' => $blokA1->id,
            'nama_lengkap' => 'Budi Santoso',
            'nik' => '3201011205850001',
            'nomor_hp' => '081234567890',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $wargaSiti = Warga::create([
            'blok_id' => $blokA1->id,
            'nama_lengkap' => 'Siti Aminah',
            'nik' => '3201015508880002',
            'nomor_hp' => '081234567891',
            'peran_keluarga' => 'istri',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $wargaAgus = Warga::create([
            'blok_id' => $blokA2->id,
            'nama_lengkap' => 'Agus Setiawan',
            'nik' => '3201011503900003',
            'nomor_hp' => '081234567892',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'kontrak',
            'is_aktif' => true,
        ]);

        $wargaDewi = Warga::create([
            'blok_id' => $blokB1->id,
            'nama_lengkap' => 'Dewi Lestari',
            'nik' => '3201016010920004',
            'nomor_hp' => '081234567893',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $wargaEko = Warga::create([
            'blok_id' => $blokB2->id,
            'nama_lengkap' => 'Eko Prasetyo',
            'nik' => '3201012207870005',
            'nomor_hp' => '081234567894',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'tetap',
            'is_aktif' => true,
        ]);

        $wargaRina = Warga::create([
            'blok_id' => $blokC1->id,
            'nama_lengkap' => 'Rina Wijaya',
            'nik' => '3201014404950006',
            'nomor_hp' => '081234567895',
            'peran_keluarga' => 'kepala_keluarga',
            'status_warga' => 'kost',
            'is_aktif' => true,
        ]);

        // 4. Seeder Jenis Iuran
        $iuranKebersihan = JenisIuran::create([
            'nama_iuran' => 'Iuran Kebersihan',
            'nominal' => 25000.00,
            'deskripsi' => 'Pengangkutan sampah rutin 3x seminggu',
            'is_aktif' => true,
        ]);

        $iuranKeamanan = JenisIuran::create([
            'nama_iuran' => 'Iuran Keamanan',
            'nominal' => 35000.00,
            'deskripsi' => 'Petugas keamanan pos satpam dan patroli malam',
            'is_aktif' => true,
        ]);

        $iuranLingkungan = JenisIuran::create([
            'nama_iuran' => 'Iuran Perawatan Lingkungan',
            'nominal' => 20000.00,
            'deskripsi' => 'Perawatan lampu jalan, drainase, dan taman',
            'is_aktif' => true,
        ]);

        // 5. Seeder Iuran Warga (Transaksi)
        // Budi Santoso - Iuran Kebersihan & Keamanan Bulan Agustus (Lunas)
        IuranWarga::create([
            'warga_id' => $wargaBudi->id,
            'jenis_iuran_id' => $iuranKebersihan->id,
            'periode' => '2026-08',
            'nominal' => 25000.00,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => '2026-08-05 10:30:00',
            'catatan' => 'Lunas via transfer BCA',
        ]);

        IuranWarga::create([
            'warga_id' => $wargaBudi->id,
            'jenis_iuran_id' => $iuranKeamanan->id,
            'periode' => '2026-08',
            'nominal' => 35000.00,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => '2026-08-05 10:30:00',
            'catatan' => 'Lunas via transfer BCA',
        ]);

        // Budi Santoso - Iuran Kebersihan & Keamanan Bulan September (Menunggu Pembayaran)
        IuranWarga::create([
            'warga_id' => $wargaBudi->id,
            'jenis_iuran_id' => $iuranKebersihan->id,
            'periode' => '2026-09',
            'nominal' => 25000.00,
            'status_pembayaran' => 'menunggu_pembayaran',
            'tanggal_pembayaran' => null,
            'catatan' => 'Tagihan iuran awal bulan',
        ]);

        IuranWarga::create([
            'warga_id' => $wargaBudi->id,
            'jenis_iuran_id' => $iuranKeamanan->id,
            'periode' => '2026-09',
            'nominal' => 35000.00,
            'status_pembayaran' => 'menunggu_pembayaran',
            'tanggal_pembayaran' => null,
            'catatan' => 'Tagihan iuran awal bulan',
        ]);

        // Agus Setiawan - Iuran Kebersihan Bulan September (Lunas)
        IuranWarga::create([
            'warga_id' => $wargaAgus->id,
            'jenis_iuran_id' => $iuranKebersihan->id,
            'periode' => '2026-09',
            'nominal' => 25000.00,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => '2026-09-02 14:15:00',
            'catatan' => 'Bayar tunai ke bendahara RT',
        ]);

        // Dewi Lestari - Iuran Keamanan Bulan September (Lunas)
        IuranWarga::create([
            'warga_id' => $wargaDewi->id,
            'jenis_iuran_id' => $iuranKeamanan->id,
            'periode' => '2026-09',
            'nominal' => 35000.00,
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => '2026-09-03 09:00:00',
            'catatan' => 'Transfer via QRIS',
        ]);

        // Eko Prasetyo - Iuran Lingkungan Bulan September (Menunggu Pembayaran)
        IuranWarga::create([
            'warga_id' => $wargaEko->id,
            'jenis_iuran_id' => $iuranLingkungan->id,
            'periode' => '2026-09',
            'nominal' => 20000.00,
            'status_pembayaran' => 'menunggu_pembayaran',
            'tanggal_pembayaran' => null,
            'catatan' => 'Menunggu konfirmasi pembayaran',
        ]);
    }
}
