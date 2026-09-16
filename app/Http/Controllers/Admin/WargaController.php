<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WargaRequest;
use App\Models\Blok;
use App\Models\Gang;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WargaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Warga::with('blok.gang')->withCount('iuranWargas');

        if ($request->filled('q')) {
            $query->where('nama_lengkap', 'like', '%'.$request->q.'%');
        }

        if ($request->filled('gang_id')) {
            $query->whereHas('blok', function ($q) use ($request) {
                $q->where('gang_id', $request->gang_id);
            });
        }

        if ($request->filled('blok_id')) {
            $query->where('blok_id', $request->blok_id);
        }

        if ($request->filled('status_warga')) {
            $query->where('status_warga', $request->status_warga);
        }

        if ($request->filled('is_aktif')) {
            $query->where('is_aktif', $request->boolean('is_aktif'));
        }

        $wargas = $query->latest('id')->paginate(10)->withQueryString();
        $gangs = Gang::where('status', 'aktif')->get();
        $bloks = Blok::where('status', 'aktif')->with('gang')->get();

        return view('admin.warga.index', compact('wargas', 'gangs', 'bloks'));
    }

    public function create(): View
    {
        $bloks = Blok::with('gang')->where('status', 'aktif')->get();

        return view('admin.warga.create', compact('bloks'));
    }

    public function store(WargaRequest $request): RedirectResponse
    {
        Warga::create($request->validated());

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data Warga berhasil ditambahkan.');
    }

    public function show(Warga $warga): View
    {
        $warga->load(['blok.gang', 'iuranWargas.jenisIuran', 'user']);

        return view('admin.warga.show', compact('warga'));
    }

    public function edit(Warga $warga): View
    {
        $bloks = Blok::with('gang')->get();

        return view('admin.warga.edit', compact('warga', 'bloks'));
    }

    public function update(WargaRequest $request, Warga $warga): RedirectResponse
    {
        $warga->update($request->validated());

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data Warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga): RedirectResponse
    {
        if ($warga->iuranWargas()->exists()) {
            return back()->with('error', 'Warga tidak dapat dihapus karena masih memiliki data riwayat iuran.');
        }

        $warga->delete();

        return redirect()->route('admin.warga.index')
            ->with('success', 'Data Warga berhasil dihapus.');
    }
}
