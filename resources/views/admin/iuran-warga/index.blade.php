@extends('layouts.dashboard')

@section('title', 'Manajemen Iuran Warga')
@section('page_heading', 'Transaksi Iuran Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tagihan & Iuran Warga</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Kelola penerbitan tagihan retribusi bulanan, verifikasi, dan pencatatan pembayaran warga.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 pl-10 sm:pl-0">
            <a href="{{ route('admin.iuran-warga.generate') }}"
               class="inline-flex items-center justify-center px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100/80 border border-indigo-200/80 rounded-xl transition shadow-2xs">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Generate Tagihan Massal
            </a>
            <a href="{{ route('admin.iuran-warga.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all duration-150">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tagihan Manual
            </a>
        </div>
    </div>

    <!-- Filter Multi Kriteria -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <form method="GET" action="{{ route('admin.iuran-warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            <!-- Cari Warga -->
            <div class="lg:col-span-3">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Nama Warga</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama warga..."
                           class="w-full text-xs rounded-xl border border-slate-300 pl-9 pr-3 py-2.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                </div>
            </div>

            <!-- Filter Jenis Iuran -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Iuran</label>
                <select name="jenis_iuran_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Jenis</option>
                    @foreach ($jenisIurans as $jenis)
                        <option value="{{ $jenis->id }}" {{ (string)request('jenis_iuran_id') === (string)$jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_iuran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Gang -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Gang</label>
                <select name="gang_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Gang</option>
                    @foreach ($gangs as $gang)
                        <option value="{{ $gang->id }}" {{ (string)request('gang_id') === (string)$gang->id ? 'selected' : '' }}>
                            {{ $gang->nama_gang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Blok -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Blok / Rumah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $b)
                        <option value="{{ $b->id }}" {{ (string)request('blok_id') === (string)$b->id ? 'selected' : '' }}>
                            {{ $b->nama_blok }} No. {{ $b->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Periode (YYYY-MM) -->
            <div class="lg:col-span-1">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Periode</label>
                <input type="text" name="periode" value="{{ request('periode') }}" placeholder="2026-09"
                       class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 font-mono text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
            </div>

            <!-- Filter Status & Tombol -->
            <div class="lg:col-span-2 flex items-end gap-2">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                    <select name="status_pembayaran" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        <option value="">Semua</option>
                        <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu</option>
                        <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <button type="submit"
                        class="py-2.5 px-3.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition shadow-xs flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Iuran Warga -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
                    <tr>
                        <th class="px-4 py-3.5 w-12 text-center">No</th>
                        <th class="px-4 py-3.5">Warga & Lokasi</th>
                        <th class="px-4 py-3.5">Jenis Iuran</th>
                        <th class="px-4 py-3.5">Periode</th>
                        <th class="px-4 py-3.5">Nominal</th>
                        <th class="px-4 py-3.5 text-center">Status</th>
                        <th class="px-4 py-3.5">Tgl Pembayaran</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($iurans as $index => $iuran)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-4 py-3.5 text-center text-slate-400 font-mono">
                                {{ $iurans->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3.5">
                                <a href="{{ route('admin.warga.show', $iuran->warga) }}" class="font-bold text-slate-900 hover:text-indigo-600 transition block">
                                    {{ $iuran->warga->nama_lengkap }}
                                </a>
                                <span class="text-[11px] text-slate-400 inline-flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    Blok {{ $iuran->warga->blok->nama_blok }} No. {{ $iuran->warga->blok->nomor_rumah }} ({{ $iuran->warga->blok->gang->nama_gang }})
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-semibold text-slate-800">
                                {{ $iuran->jenisIuran->nama_iuran }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-700">
                                <span class="bg-slate-100 px-2 py-0.5 rounded text-[11px] font-semibold">{{ $iuran->periode }}</span>
                            </td>
                            <td class="px-4 py-3.5 font-bold text-slate-900 font-mono">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 font-mono text-[11px]">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <!-- Tombol Cepat Bayar / Batal Bayar -->
                                @if ($iuran->status_pembayaran === 'menunggu_pembayaran')
                                    <form action="{{ route('admin.iuran-warga.bayar', $iuran) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Konfirmasi tandai lunas tagihan ini?');">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition"
                                                title="Tandai Sudah Lunas">
                                            Bayar
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.iuran-warga.batal-bayar', $iuran) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Batalkan status pembayaran tagihan ini?');">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition"
                                                title="Batalkan Pembayaran">
                                            Batal
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:text-indigo-600 bg-slate-100/80 hover:bg-slate-200/80 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.iuran-warga.edit', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.iuran-warga.destroy', $iuran) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan iuran ini?');">
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
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada data tagihan atau iuran</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Sesuaikan kriteria filter atau generate tagihan massal untuk warga aktif.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($iurans->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
                {{ $iurans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
