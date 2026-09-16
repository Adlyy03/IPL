<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $query = IuranWarga::with(['warga.blok.gang', 'jenisIuran']);

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('jenis_iuran_id')) {
            $query->where('jenis_iuran_id', $request->jenis_iuran_id);
        }

        if ($request->filled('gang_id')) {
            $query->whereHas('warga.blok', function ($q) use ($request) {
                $q->where('gang_id', $request->gang_id);
            });
        }

        if ($request->filled('blok_id')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('blok_id', $request->blok_id);
            });
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Clone query untuk hitung ringkasan statistik laporan terfilter
        $ringkasanLaporan = [
            'total_tagihan' => (clone $query)->count(),
            'total_sudah_bayar' => (clone $query)->where('status_pembayaran', 'lunas')->count(),
            'total_belum_bayar' => (clone $query)->where('status_pembayaran', 'menunggu_pembayaran')->count(),
            'total_nominal_tagihan' => (clone $query)->sum('nominal'),
            'total_nominal_pembayaran' => (clone $query)->where('status_pembayaran', 'lunas')->sum('nominal'),
        ];

        $daftarLaporan = $query->latest('id')->paginate(20)->withQueryString();

        $gangs = Gang::where('status', 'aktif')->get();
        $bloks = Blok::where('status', 'aktif')->with('gang')->get();
        $jenisIurans = JenisIuran::where('is_aktif', true)->get();

        return view('admin.laporan.index', compact(
            'ringkasanLaporan',
            'daftarLaporan',
            'gangs',
            'bloks',
            'jenisIurans'
        ));
    }
}
