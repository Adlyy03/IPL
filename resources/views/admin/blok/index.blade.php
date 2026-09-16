@extends('layouts.dashboard')

@section('title', 'Manajemen Blok & Rumah')
@section('page_heading', 'Master Data Blok & Rumah')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Data Blok & Rumah</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data blok dan nomor rumah warga di setiap gang.</p>
        </div>
        <a href="{{ route('admin.blok.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Blok Baru
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.blok.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-3">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Blok</label>
                <input type="text" name="nama_blok" value="{{ request('nama_blok') }}" placeholder="Contoh: Blok A"
                       class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="sm:col-span-3">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nomor Rumah</label>
                <input type="text" name="nomor_rumah" value="{{ request('nomor_rumah') }}" placeholder="Contoh: 12"
                       class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="sm:col-span-3">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Gang</label>
                <select name="gang_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Gang</option>
                    @foreach ($gangs as $gang)
                        <option value="{{ $gang->id }}" {{ request('gang_id') == $gang->id ? 'selected' : '' }}>
                            {{ $gang->nama_gang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status</label>
                <select name="status" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="sm:col-span-1 flex items-end">
                <button type="submit" class="w-full py-2 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Blok -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Blok</th>
                        <th class="px-5 py-3.5">Nomor Rumah</th>
                        <th class="px-5 py-3.5">Lokasi Gang</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Penghuni Terdata</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($bloks as $index => $blok)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400">
                                {{ $bloks->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.blok.show', $blok) }}" class="hover:text-indigo-600">
                                    {{ $blok->nama_blok }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">
                                No. {{ $blok->nomor_rumah }}
                            </td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('admin.gang.show', $blok->gang) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    {{ $blok->gang->nama_gang }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($blok->status === 'aktif')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $blok->wargas_count }} Jiwa
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.blok.show', $blok) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.blok.edit', $blok) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.blok.destroy', $blok) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus blok ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada data blok atau rumah yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bloks->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $bloks->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
