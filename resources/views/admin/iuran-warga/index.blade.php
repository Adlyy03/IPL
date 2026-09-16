@extends('layouts.dashboard')

@section('title', 'Manajemen Iuran Warga')
@section('page_heading', 'Transaksi Iuran Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tagihan & Iuran Warga</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola penerbitan tagihan retribusi dan pencatatan pembayaran warga.</p>
        </div>
        <div class="flex items-center space-x-2.5">
            <a href="{{ route('admin.iuran-warga.generate') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Generate Tagihan Massal
            </a>
            <a href="{{ route('admin.iuran-warga.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Tagihan Manual
            </a>
        </div>
    </div>

    <!-- Filter Multi Kriteria -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.iuran-warga.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <!-- Cari Warga -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Cari Warga</label>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Nama warga..."
                       class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Filter Jenis Iuran -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Jenis Iuran</label>
                <select name="jenis_iuran_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Jenis</option>
                    @foreach ($jenisIurans as $jenis)
                        <option value="{{ $jenis->id }}" {{ (string)request('jenis_iuran_id') === (string)$jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_iuran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Gang -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Pilih Gang</label>
                <select name="gang_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Gang</option>
                    @foreach ($gangs as $gang)
                        <option value="{{ $gang->id }}" {{ (string)request('gang_id') === (string)$gang->id ? 'selected' : '' }}>
                            {{ $gang->nama_gang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Blok -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Blok / Rumah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $b)
                        <option value="{{ $b->id }}" {{ (string)request('blok_id') === (string)$b->id ? 'selected' : '' }}>
                            {{ $b->nama_blok }} No. {{ $b->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Periode (YYYY-MM) -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Periode (YYYY-MM)</label>
                <input type="text" name="periode" value="{{ request('periode') }}" placeholder="Contoh: 2026-09"
                       class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Filter Status & Tombol -->
            <div class="flex items-end space-x-2">
                <div class="flex-1">
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status</label>
                    <select name="status_pembayaran" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua</option>
                        <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu</option>
                        <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <button type="submit" class="py-2 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Tabel Data Iuran Warga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
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
                            <td class="px-4 py-3.5 text-center text-slate-400">
                                {{ $iurans->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3.5">
                                <a href="{{ route('admin.warga.show', $iuran->warga) }}" class="font-bold text-slate-900 hover:text-indigo-600 block">
                                    {{ $iuran->warga->nama_lengkap }}
                                </a>
                                <span class="text-[11px] text-slate-400">
                                    Blok {{ $iuran->warga->blok->nama_blok }} No. {{ $iuran->warga->blok->nomor_rumah }} ({{ $iuran->warga->blok->gang->nama_gang }})
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-medium text-slate-800">
                                {{ $iuran->jenisIuran->nama_iuran }}
                            </td>
                            <td class="px-4 py-3.5 font-mono text-slate-700">
                                {{ $iuran->periode }}
                            </td>
                            <td class="px-4 py-3.5 font-bold text-slate-900">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Lunas
                                    </span>
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-slate-600">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <!-- Tombol Cepat Bayar / Batal Bayar -->
                                @if ($iuran->status_pembayaran === 'menunggu_pembayaran')
                                    <form action="{{ route('admin.iuran-warga.bayar', $iuran) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Konfirmasi tandai lunas tagihan ini?');">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition"
                                                title="Tandai Sudah Lunas">
                                            Bayar
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.iuran-warga.batal-bayar', $iuran) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Batalkan status pembayaran tagihan ini?');">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-2 py-1 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition"
                                                title="Batalkan Pembayaran">
                                            Batal
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.iuran-warga.edit', $iuran) }}"
                                   class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.iuran-warga.destroy', $iuran) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan iuran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-slate-400">
                                Tidak ada data tagihan atau iuran yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($iurans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $iurans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
