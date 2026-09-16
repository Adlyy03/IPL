<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\IuranWarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard warga yang sedang login.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        // Data warga diambil HANYA dari relasi user yang sedang login
        $warga = $user->warga?->load('blok.gang');

        $periodeBulanIni = now()->format('Y-m');
        $riwayatIuran = collect();
        $ringkasanWarga = [
            'nama_warga' => $warga?->nama_lengkap ?? $user->name,
            'blok_dan_nomor' => $warga ? ($warga->blok->nama_blok.' No. '.$warga->blok->nomor_rumah) : '-',
            'nama_gang' => $warga?->blok?->gang?->nama_gang ?? '-',
            'total_tagihan_belum_dibayar' => 0,
            'total_tagihan_sudah_dibayar' => 0,
            'nominal_tagihan_bulan_berjalan' => 0,
        ];

        if ($warga) {
            // Seluruh query iuran dikunci mutlak dengan warga_id milik user login
            $riwayatIuran = IuranWarga::with('jenisIuran')
                ->where('warga_id', $warga->id)
                ->orderByDesc('periode')
                ->orderByDesc('id')
                ->get();

            $ringkasanWarga['total_tagihan_belum_dibayar'] = $riwayatIuran
                ->where('status_pembayaran', 'menunggu_pembayaran')
                ->count();

            $ringkasanWarga['total_tagihan_sudah_dibayar'] = $riwayatIuran
                ->where('status_pembayaran', 'lunas')
                ->count();

            $ringkasanWarga['nominal_tagihan_bulan_berjalan'] = $riwayatIuran
                ->where('periode', $periodeBulanIni)
                ->sum('nominal');
        }

        return view('warga.dashboard', compact(
            'user',
            'warga',
            'riwayatIuran',
            'ringkasanWarga',
            'periodeBulanIni'
        ));
    }
}
