<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class IuranController extends Controller
{
    /**
     * Tampilkan daftar tagihan iuran milik warga login.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $warga = $user->warga?->load('blok.gang');

        $daftarIuran = collect();
        $ringkasan = [
            'total_tagihan' => 0,
            'total_lunas' => 0,
            'total_belum_bayar' => 0,
            'total_nominal' => 0,
        ];

        if ($warga) {
            // Filter ketat di level query database berdasarkan ID warga milik user login
            $baseQuery = IuranWarga::where('warga_id', $warga->id);

            $ringkasan['total_tagihan'] = (clone $baseQuery)->count();
            $ringkasan['total_lunas'] = (clone $baseQuery)->where('status_pembayaran', 'lunas')->count();
            $ringkasan['total_belum_bayar'] = (clone $baseQuery)->where('status_pembayaran', 'menunggu_pembayaran')->count();
            $ringkasan['total_nominal'] = (clone $baseQuery)->sum('nominal');

            $query = IuranWarga::with('jenisIuran')
                ->where('warga_id', $warga->id);

            if ($request->filled('periode')) {
                $query->where('periode', $request->periode);
            }

            if ($request->filled('status_pembayaran')) {
                $query->where('status_pembayaran', $request->status_pembayaran);
            }

            if ($request->filled('jenis_iuran_id')) {
                $query->where('jenis_iuran_id', $request->jenis_iuran_id);
            }

            if ($request->filled('q')) {
                $q = $request->q;
                $query->where(function ($sub) use ($q) {
                    $sub->where('periode', 'like', "%{$q}%")
                        ->orWhereHas('jenisIuran', function ($j) use ($q) {
                            $j->where('nama_iuran', 'like', "%{$q}%");
                        });
                });
            }

            $totalNominal = (clone $query)->sum('nominal');
            $daftarIuran = $query->orderByDesc('periode')->orderByDesc('id')->paginate(12)->withQueryString();
        } else {
            $totalNominal = 0;
            $daftarIuran = new LengthAwarePaginator([], 0, 12);
        }

        $jenisIurans = JenisIuran::where('is_aktif', true)->orderBy('nama_iuran')->get();

        return view('warga.iuran.index', compact(
            'daftarIuran',
            'warga',
            'jenisIurans',
            'totalNominal',
            'ringkasan'
        ));
    }

    /**
     * Tampilkan detail rincian iuran tertentu (dengan proteksi isolasi data).
     */
    public function show(Request $request, IuranWarga $iuranWarga): View
    {
        /** @var User $user */
        $user = $request->user();

        // Validasi isolasi data: hanya warga pemilik tagihan atau admin yang boleh melihat
        if (! $user->isAdmin() && (! $user->warga_id || (int) $user->warga_id !== (int) $iuranWarga->warga_id)) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat rincian tagihan iuran ini.');
        }

        $iuranWarga->load(['warga.blok.gang', 'jenisIuran']);

        return view('warga.iuran.show', compact('iuranWarga', 'user'));
    }
}
