<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\Warga;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     */
    public function index(): View
    {
        $periodeBulanIni = now()->format('Y-m');

        $ringkasanUtama = [
            'total_gang' => Gang::count(),
            'total_blok' => Blok::count(),
            'total_warga' => Warga::count(),
            'total_jenis_iuran' => JenisIuran::count(),
            'total_iuran_belum_dibayar' => IuranWarga::where('status_pembayaran', 'menunggu_pembayaran')->count(),
            'total_iuran_sudah_dibayar' => IuranWarga::where('status_pembayaran', 'lunas')->count(),
            'nominal_iuran_bulan_berjalan' => IuranWarga::where('periode', $periodeBulanIni)->sum('nominal'),
        ];

        $ringkasanPembayaran = [
            'jumlah_sudah_bayar' => IuranWarga::where('status_pembayaran', 'lunas')->count(),
            'jumlah_belum_bayar' => IuranWarga::where('status_pembayaran', 'menunggu_pembayaran')->count(),
            'total_nominal_pembayaran' => IuranWarga::where('status_pembayaran', 'lunas')->sum('nominal'),
            'total_tagihan' => IuranWarga::sum('nominal'),
        ];

        $iuranTerbaru = IuranWarga::with(['warga.blok.gang', 'jenisIuran'])
            ->latest('id')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'ringkasanUtama',
            'ringkasanPembayaran',
            'iuranTerbaru',
            'periodeBulanIni'
        ));
    }
}
