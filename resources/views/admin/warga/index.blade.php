@extends('layouts.dashboard')

@section('title', 'Manajemen Data Warga')
@section('page_heading', 'Master Data Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Data Warga & Kependudukan</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Kelola master identitas warga, status kependudukan, peran keluarga, dan domisili hunian.</p>
        </div>
        <div class="flex items-center gap-2 pl-10 sm:pl-0">
            <a href="{{ route('admin.warga.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all duration-150">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Warga Baru
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <form method="GET" action="{{ route('admin.warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            <div class="lg:col-span-4">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pencarian Nama</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama lengkap warga..."
                           class="w-full text-xs rounded-xl border border-slate-300 pl-9 pr-3 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                </div>
            </div>
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Gang</label>
                <select name="gang_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Gang</option>
                    @foreach ($gangs as $gang)
                        <option value="{{ $gang->id }}" {{ request('gang_id') == $gang->id ? 'selected' : '' }}>
                            {{ $gang->nama_gang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Blok / Rumah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ request('blok_id') == $blok->id ? 'selected' : '' }}>
                            {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Warga</label>
                <select name="status_warga" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Status</option>
                    <option value="tetap" {{ request('status_warga') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                    <option value="kontrak" {{ request('status_warga') === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                    <option value="kost" {{ request('status_warga') === 'kost' ? 'selected' : '' }}>Kost</option>
                </select>
            </div>
            <div class="lg:col-span-1 flex items-end">
                <button type="submit"
                        class="w-full py-2.5 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition shadow-xs flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Warga -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">
                                {{ $wargas->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.warga.show', $warga) }}" class="hover:text-indigo-600 transition inline-flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs border border-slate-200/60">
                                        {{ substr($warga->nama_lengkap, 0, 1) }}
                                    </span>
                                    <span>{{ $warga->nama_lengkap }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600 text-[11px]">
                                {{ $warga->nik ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600 text-[11px]">
                                {{ $warga->nomor_hp ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-semibold text-slate-800 block">
                                    Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}
                                </span>
                                <span class="text-[11px] text-slate-400 inline-flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    {{ $warga->blok->gang->nama_gang }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ ucwords(str_replace('_', ' ', $warga->peran_keluarga)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $warga->status_warga === 'tetap' ? 'bg-sky-50 text-sky-700 border border-sky-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                    {{ ucfirst($warga->status_warga) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($warga->is_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.warga.show', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:text-indigo-600 bg-slate-100/80 hover:bg-slate-200/80 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.warga.edit', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.warga.destroy', $warga) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada data warga terdaftar</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Silakan tambahkan data warga baru atau sesuaikan filter pencarian Anda di atas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($wargas->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
                {{ $wargas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
