<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IuranController extends Controller
{
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $warga = $user->warga;

        $daftarIuran = collect();
        $totalNominal = 0;

        if ($warga) {
            // Filter ketat di level query database berdasarkan ID warga milik user login
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

            $totalNominal = (clone $query)->sum('nominal');
            $daftarIuran = $query->orderByDesc('periode')->orderByDesc('id')->paginate(15)->withQueryString();
        }

        $jenisIurans = JenisIuran::where('is_aktif', true)->get();

        return view('warga.iuran.index', compact('daftarIuran', 'warga', 'jenisIurans', 'totalNominal'));
    }
}
