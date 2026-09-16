<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JenisIuranRequest;
use App\Models\JenisIuran;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisIuranController extends Controller
{
    public function index(): View
    {
        $jenisIurans = JenisIuran::withCount('iuranWargas')
            ->latest('id')
            ->paginate(10);

        return view('admin.jenis-iuran.index', compact('jenisIurans'));
    }

    public function create(): View
    {
        return view('admin.jenis-iuran.create');
    }

    public function store(JenisIuranRequest $request): RedirectResponse
    {
        JenisIuran::create($request->validated());

        return redirect()->route('admin.jenis-iuran.index')
            ->with('success', 'Jenis Iuran berhasil ditambahkan.');
    }

    public function show(JenisIuran $jenisIuran): View
    {
        $jenisIuran->load(['iuranWargas.warga.blok.gang']);

        return view('admin.jenis-iuran.show', compact('jenisIuran'));
    }

    public function edit(JenisIuran $jenisIuran): View
    {
        return view('admin.jenis-iuran.edit', compact('jenisIuran'));
    }

    public function update(JenisIuranRequest $request, JenisIuran $jenisIuran): RedirectResponse
    {
        $jenisIuran->update($request->validated());

        return redirect()->route('admin.jenis-iuran.index')
            ->with('success', 'Jenis Iuran berhasil diperbarui.');
    }

    public function destroy(JenisIuran $jenisIuran): RedirectResponse
    {
        if ($jenisIuran->iuranWargas()->exists()) {
            return back()->with('error', 'Jenis iuran tidak dapat dihapus karena sudah memiliki transaksi iuran tercatat.');
        }

        $jenisIuran->delete();

        return redirect()->route('admin.jenis-iuran.index')
            ->with('success', 'Jenis Iuran berhasil dihapus.');
    }
}
