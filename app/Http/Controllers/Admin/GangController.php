<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GangRequest;
use App\Models\Gang;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GangController extends Controller
{
    public function index(): View
    {
        $gangs = Gang::withCount('bloks')
            ->latest('id')
            ->paginate(10);

        return view('admin.gang.index', compact('gangs'));
    }

    public function create(): View
    {
        return view('admin.gang.create');
    }

    public function store(GangRequest $request): RedirectResponse
    {
        Gang::create($request->validated());

        return redirect()->route('admin.gang.index')
            ->with('success', 'Data Gang berhasil ditambahkan.');
    }

    public function show(Gang $gang): View
    {
        $gang->load(['bloks' => function ($query) {
            $query->withCount('wargas');
        }]);

        return view('admin.gang.show', compact('gang'));
    }

    public function edit(Gang $gang): View
    {
        return view('admin.gang.edit', compact('gang'));
    }

    public function update(GangRequest $request, Gang $gang): RedirectResponse
    {
        $gang->update($request->validated());

        return redirect()->route('admin.gang.index')
            ->with('success', 'Data Gang berhasil diperbarui.');
    }

    public function destroy(Gang $gang): RedirectResponse
    {
        if ($gang->bloks()->exists()) {
            return back()->with('error', 'Gang tidak dapat dihapus karena masih memiliki data Blok/Rumah.');
        }

        $gang->delete();

        return redirect()->route('admin.gang.index')
            ->with('success', 'Data Gang berhasil dihapus.');
    }
}
