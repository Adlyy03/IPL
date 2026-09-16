<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlokRequest;
use App\Models\Blok;
use App\Models\Gang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlokController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blok::with('gang')->withCount('wargas');

        if ($request->filled('gang_id')) {
            $query->where('gang_id', $request->gang_id);
        }

        if ($request->filled('nama_blok')) {
            $query->where('nama_blok', 'like', '%'.$request->nama_blok.'%');
        }

        if ($request->filled('nomor_rumah')) {
            $query->where('nomor_rumah', 'like', '%'.$request->nomor_rumah.'%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bloks = $query->latest('id')->paginate(10)->withQueryString();
        $gangs = Gang::where('status', 'aktif')->get();

        return view('admin.blok.index', compact('bloks', 'gangs'));
    }

    public function create(): View
    {
        $gangs = Gang::where('status', 'aktif')->get();

        return view('admin.blok.create', compact('gangs'));
    }

    public function store(BlokRequest $request): RedirectResponse
    {
        Blok::create($request->validated());

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data Blok & Rumah berhasil ditambahkan.');
    }

    public function show(Blok $blok): View
    {
        $blok->load(['gang', 'wargas.iuranWargas']);

        return view('admin.blok.show', compact('blok'));
    }

    public function edit(Blok $blok): View
    {
        $gangs = Gang::all();

        return view('admin.blok.edit', compact('blok', 'gangs'));
    }

    public function update(BlokRequest $request, Blok $blok): RedirectResponse
    {
        $blok->update($request->validated());

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data Blok & Rumah berhasil diperbarui.');
    }

    public function destroy(Blok $blok): RedirectResponse
    {
        if ($blok->wargas()->exists()) {
            return back()->with('error', 'Blok/Rumah tidak dapat dihapus karena masih ada data penghuni/warga tercatat.');
        }

        $blok->delete();

        return redirect()->route('admin.blok.index')
            ->with('success', 'Data Blok & Rumah berhasil dihapus.');
    }
}
