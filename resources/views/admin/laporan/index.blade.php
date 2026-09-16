@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan IPL')
@section('page_heading', 'Laporan Keuangan & Rekapitulasi IPL')

@section('content')
<div class="space-y-6">
    <!-- Header & Print Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 print:hidden">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Penerimaan & Rekapitulasi IPL</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Ringkasan arus kas iuran lingkungan berdasarkan filter periode, jenis iuran, dan wilayah.</p>
        </div>
        <div class="pl-10 sm:pl-0">
            <button onclick="window.print()"
                    class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-2xs transition">
                <svg class="w-4 h-4 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Print-only Title Header -->
    <div class="hidden print:block mb-6 pb-4 border-b border-slate-300">
        <h2 class="text-lg font-bold text-slate-900">LAPORAN REKAPITULASI IURAN PENGELOLAAN LINGKUNGAN (IPL)</h2>
        <p class="text-xs text-slate-500 mt-1">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} | Periode: {{ request('periode', 'Semua Periode') }}</p>
    </div>

    <!-- Filter Multi Kriteria -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs print:hidden">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
            <!-- Filter Periode (YYYY-MM) -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Periode (YYYY-MM)</label>
                <input type="text" name="periode" value="{{ request('periode') }}" placeholder="Contoh: 2026-09"
                       class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 font-mono text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
            </div>

            <!-- Filter Jenis Iuran -->
            <div class="lg:col-span-3">
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
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Blok / Wilayah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ (string)request('blok_id') === (string)$blok->id ? 'selected' : '' }}>
                            {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Bayar -->
            <div class="lg:col-span-1">
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status_pembayaran" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="">Semua</option>
                    <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu</option>
                    <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="lg:col-span-2 flex items-end gap-2">
                <button type="submit"
                        class="flex-1 py-2.5 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl transition shadow-xs flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Filter</span>
                </button>
                <a href="{{ route('admin.laporan.index') }}"
                   class="py-2.5 px-3 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition flex items-center justify-center"
                   title="Reset Filter">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan Finansial (KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Total Nilai Tagihan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Nilai Tagihan</span>
                <span class="p-2 rounded-xl bg-slate-100 text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
            </div>
            <span class="text-2xl font-black text-slate-900 mt-3 block font-mono">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'], 0, ',', '.') }}</span>
            <span class="inline-flex items-center gap-1 text-xs text-slate-500 mt-2 font-medium">
                <span class="font-bold text-slate-700">{{ $ringkasanLaporan['total_tagihan'] }}</span> Tagihan Diterbitkan
            </span>
        </div>

        <!-- Total Terbayar (Lunas) -->
        <div class="bg-white p-6 rounded-2xl border border-emerald-200/80 shadow-xs relative overflow-hidden bg-gradient-to-br from-white to-emerald-50/30">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider block">Total Penerimaan (Lunas)</span>
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <span class="text-2xl font-black text-emerald-700 mt-3 block font-mono">Rp {{ number_format($ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</span>
            <span class="inline-flex items-center gap-1 text-xs text-emerald-700 mt-2 font-medium">
                <span class="font-bold">{{ $ringkasanLaporan['total_sudah_bayar'] }}</span> Transaksi Berhasil Masuk Kas
            </span>
        </div>

        <!-- Total Piutang / Tunggakan -->
        <div class="bg-white p-6 rounded-2xl border border-amber-200/80 shadow-xs relative overflow-hidden bg-gradient-to-br from-white to-amber-50/30">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider block">Total Menunggu Pembayaran</span>
                <span class="p-2 rounded-xl bg-amber-100 text-amber-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
            </div>
            <span class="text-2xl font-black text-amber-700 mt-3 block font-mono">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'] - $ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</span>
            <span class="inline-flex items-center gap-1 text-xs text-amber-700 mt-2 font-medium">
                <span class="font-bold">{{ $ringkasanLaporan['total_belum_bayar'] }}</span> Tagihan Belum Dilunasi Warga
            </span>
        </div>
    </div>

    <!-- Detail Rincian Transaksi -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/90 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Detail Transaksi Laporan</h3>
                <p class="text-xs text-slate-500 mt-0.5">Rincian seluruh pencatatan tagihan dan kas penerimaan</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 w-fit">
                {{ $daftarLaporan->total() }} data ditemukan
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Warga & Rumah</th>
                        <th class="px-5 py-3.5">Jenis Iuran</th>
                        <th class="px-5 py-3.5">Periode</th>
                        <th class="px-5 py-3.5">Nominal</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5">Tgl Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($daftarLaporan as $index => $trx)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">
                                {{ $daftarLaporan->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-slate-900 block">{{ $trx->warga->nama_lengkap }}</span>
                                <span class="text-[11px] text-slate-400 inline-flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    Blok {{ $trx->warga->blok->nama_blok }} No. {{ $trx->warga->blok->nomor_rumah }} ({{ $trx->warga->blok->gang->nama_gang }})
                                </span>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-800">
                                {{ $trx->jenisIuran->nama_iuran }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-700">
                                <span class="bg-slate-100 px-2 py-0.5 rounded text-[11px] font-semibold">{{ $trx->periode }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 font-mono">
                                Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($trx->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @elseif ($trx->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono text-[11px]">
                                {{ $trx->tanggal_pembayaran ? \Carbon\Carbon::parse($trx->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Tidak ada transaksi yang sesuai</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Coba sesuaikan filter periode, gang, blok, atau jenis iuran untuk menampilkan rekapitulasi data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarLaporan->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-slate-50/50 print:hidden">
                {{ $daftarLaporan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
