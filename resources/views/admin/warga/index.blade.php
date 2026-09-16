@extends('layouts.dashboard')

@section('title', 'Manajemen Data Warga')
@section('page_heading', 'Master Data Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Data Warga & Kependudukan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola identitas warga, status kependudukan, dan relasi hunian.</p>
        </div>
        <a href="{{ route('admin.warga.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Warga Baru
        </a>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-600 mb-1">Pencarian</label>
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama warga..."
                           class="w-full text-xs rounded-xl border-slate-300 pl-9 pr-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div>
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
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Blok / Rumah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ request('blok_id') == $blok->id ? 'selected' : '' }}>
                            {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Status Warga</label>
                <select name="status_warga" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="tetap" {{ request('status_warga') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="kontrak" {{ request('status_warga') === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="kost" {{ request('status_warga') === 'kost' ? 'selected' : '' }}>Kost</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full py-2 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Warga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Lengkap</th>
                        <th class="px-5 py-3.5">NIK</th>
                        <th class="px-5 py-3.5">No. HP</th>
                        <th class="px-5 py-3.5">Hunian (Blok & Gang)</th>
                        <th class="px-5 py-3.5 text-center">Peran</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Keaktifan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($wargas as $index => $warga)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400">
                                {{ $wargas->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.warga.show', $warga) }}" class="hover:text-indigo-600">
                                    {{ $warga->nama_lengkap }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">
                                {{ $warga->nik ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">
                                {{ $warga->nomor_hp ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-medium text-slate-800">
                                    Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}
                                </span>
                                <span class="block text-[11px] text-slate-400">
                                    {{ $warga->blok->gang->nama_gang }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700">
                                    {{ ucwords(str_replace('_', ' ', $warga->peran_keluarga)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $warga->status_warga === 'tetap' ? 'bg-sky-100 text-sky-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ ucfirst($warga->status_warga) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($warga->is_aktif)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.warga.show', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.warga.edit', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.warga.destroy', $warga) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?');">
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
                            <td colspan="9" class="px-5 py-8 text-center text-slate-400">
                                Belum ada data warga yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($wargas->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $wargas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
