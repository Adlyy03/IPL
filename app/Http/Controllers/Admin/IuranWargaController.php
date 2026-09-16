<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateIuranRequest;
use App\Http\Requests\IuranWargaRequest;
use App\Models\Blok;
use App\Models\Gang;
use App\Models\IuranWarga;
use App\Models\JenisIuran;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IuranWargaController extends Controller
{
    public function index(Request $request): View
    {
        $query = IuranWarga::with(['warga.blok.gang', 'jenisIuran']);

        if ($request->filled('q')) {
            $query->whereHas('warga', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->q.'%');
            });
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

        if ($request->filled('jenis_iuran_id')) {
            $query->where('jenis_iuran_id', $request->jenis_iuran_id);
        }

        if ($request->filled('periode')) {
            $query->where('periode', $request->periode);
        }

        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        $iurans = $query->latest('id')->paginate(15)->withQueryString();

        $gangs = Gang::where('status', 'aktif')->get();
        $bloks = Blok::where('status', 'aktif')->with('gang')->get();
        $jenisIurans = JenisIuran::where('is_aktif', true)->get();

        return view('admin.iuran-warga.index', compact('iurans', 'gangs', 'bloks', 'jenisIurans'));
    }

    public function create(): View
    {
        $wargas = Warga::with('blok.gang')->where('is_aktif', true)->orderBy('nama_lengkap')->get();
        $jenisIurans = JenisIuran::where('is_aktif', true)->get();

        return view('admin.iuran-warga.create', compact('wargas', 'jenisIurans'));
    }

    public function store(IuranWargaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Cegah tagihan duplikat untuk warga + jenis iuran + periode sama
        $exists = IuranWarga::where('warga_id', $validated['warga_id'])
            ->where('jenis_iuran_id', $validated['jenis_iuran_id'])
            ->where('periode', $validated['periode'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'Tagihan untuk warga ini pada periode dan jenis iuran tersebut sudah ada.');
        }

        IuranWarga::create($validated);

        return redirect()->route('admin.iuran-warga.index')
            ->with('success', 'Tagihan iuran warga berhasil dibuat.');
    }

    public function show(IuranWarga $iuranWarga): View
    {
        $iuranWarga->load(['warga.blok.gang', 'jenisIuran']);

        return view('admin.iuran-warga.show', compact('iuranWarga'));
    }

    public function edit(IuranWarga $iuranWarga): View
    {
        $wargas = Warga::with('blok.gang')->where('is_aktif', true)->get();
        $jenisIurans = JenisIuran::where('is_aktif', true)->get();

        return view('admin.iuran-warga.edit', compact('iuranWarga', 'wargas', 'jenisIurans'));
    }

    public function update(IuranWargaRequest $request, IuranWarga $iuranWarga): RedirectResponse
    {
        $iuranWarga->update($request->validated());

        return redirect()->route('admin.iuran-warga.index')
            ->with('success', 'Data tagihan iuran berhasil diperbarui.');
    }

    public function destroy(IuranWarga $iuranWarga): RedirectResponse
    {
        $iuranWarga->delete();

        return redirect()->route('admin.iuran-warga.index')
            ->with('success', 'Tagihan iuran berhasil dihapus.');
    }

    /**
     * Tampilkan formulir generate tagihan massal.
     */
    public function generateView(): View
    {
        $jenisIurans = JenisIuran::where('is_aktif', true)->get();
        $gangs = Gang::where('status', 'aktif')->get();
        $bloks = Blok::where('status', 'aktif')->with('gang')->get();

        return view('admin.iuran-warga.generate', compact('jenisIurans', 'gangs', 'bloks'));
    }

    /**
     * Eksekusi generate tagihan massal untuk banyak warga sekaligus.
     */
    public function generateStore(GenerateIuranRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $queryWarga = Warga::query()->where('is_aktif', true);

        if ($validated['hanya_kepala_keluarga'] ?? true) {
            $queryWarga->where('peran_keluarga', 'kepala_keluarga');
        }

        if ($validated['cakupan'] === 'gang') {
            $queryWarga->whereHas('blok', function ($q) use ($validated) {
                $q->where('gang_id', $validated['gang_id']);
            });
        } elseif ($validated['cakupan'] === 'blok') {
            $queryWarga->where('blok_id', $validated['blok_id']);
        }

        $daftarWarga = $queryWarga->get();

        if ($daftarWarga->isEmpty()) {
            return back()->withInput()->with('error', 'Tidak ditemukan warga aktif yang sesuai dengan kriteria cakupan.');
        }

        $berhasil = 0;
        $dilewati = 0;

        DB::transaction(function () use ($daftarWarga, $validated, &$berhasil, &$dilewati) {
            foreach ($daftarWarga as $warga) {
                // Cek duplikasi tagihan
                $sudahAda = IuranWarga::where('warga_id', $warga->id)
                    ->where('jenis_iuran_id', $validated['jenis_iuran_id'])
                    ->where('periode', $validated['periode'])
                    ->exists();

                if ($sudahAda) {
                    $dilewati++;

                    continue;
                }

                IuranWarga::create([
                    'warga_id' => $warga->id,
                    'jenis_iuran_id' => $validated['jenis_iuran_id'],
                    'periode' => $validated['periode'],
                    'nominal' => $validated['nominal'],
                    'status_pembayaran' => 'menunggu_pembayaran',
                    'tanggal_pembayaran' => null,
                    'catatan' => 'Tagihan generate massal periode '.$validated['periode'],
                ]);

                $berhasil++;
            }
        });

        $pesan = "Proses selesai! {$berhasil} tagihan baru berhasil digenerate.";
        if ($dilewati > 0) {
            $pesan .= " ({$dilewati} tagihan dilewati karena sudah ada).";
        }

        return redirect()->route('admin.iuran-warga.index')->with('success', $pesan);
    }

    /**
     * Tandai iuran sebagai sudah bayar (lunas).
     */
    public function bayar(Request $request, IuranWarga $iuranWarga): RedirectResponse
    {
        $iuranWarga->update([
            'status_pembayaran' => 'lunas',
            'tanggal_pembayaran' => now(),
            'catatan' => $request->input('catatan', $iuranWarga->catatan ?? 'Lunas diverifikasi pengurus'),
        ]);

        return back()->with('success', 'Pembayaran iuran berhasil dicatat.');
    }

    /**
     * Batalkan status pembayaran iuran kembali ke menunggu pembayaran.
     */
    public function batalBayar(IuranWarga $iuranWarga): RedirectResponse
    {
        $iuranWarga->update([
            'status_pembayaran' => 'menunggu_pembayaran',
            'tanggal_pembayaran' => null,
            'catatan' => 'Pembayaran dibatalkan oleh admin pada '.now()->format('d/m/Y H:i'),
        ]);

        return back()->with('success', 'Status pembayaran berhasil dibatalkan kembali ke Menunggu.');
    }
}
