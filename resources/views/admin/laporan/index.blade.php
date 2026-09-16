@extends('layouts.dashboard')

@section('title', 'Laporan Keuangan IPL')
@section('page_heading', 'Laporan Keuangan & Rekapitulasi IPL')

@section('content')
<div class="space-y-6">
    <!-- Header & Print Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Laporan Penerimaan & Rekapitulasi IPL</h1>
            <p class="text-xs text-slate-500 mt-0.5">Ringkasan arus kas iuran lingkungan berdasarkan filter periode dan wilayah.</p>
        </div>
        <button onclick="window.print()"
                class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-sm transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Laporan
        </button>
    </div>

    <!-- Filter Multi Kriteria -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm print:hidden">
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <!-- Filter Periode (YYYY-MM) -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Periode (YYYY-MM)</label>
                <input type="text" name="periode" value="{{ request('periode') }}" placeholder="Contoh: 2026-09"
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
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Blok / Wilayah</label>
                <select name="blok_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Blok</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ (string)request('blok_id') === (string)$blok->id ? 'selected' : '' }}>
                            {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status Bayar -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-600 mb-1">Status Bayar</label>
                <select name="status_pembayaran" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="w-full py-2 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                    Terapkan
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="py-2 px-3 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Ringkasan Finansial (KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Total Nilai Tagihan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Nilai Tagihan</span>
            <span class="text-2xl font-black text-slate-900 mt-2 block">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'], 0, ',', '.') }}</span>
            <span class="text-xs text-slate-400 mt-1 block">{{ $ringkasanLaporan['total_tagihan'] }} Tagihan Diterbitkan</span>
        </div>

        <!-- Total Terbayar (Lunas) -->
        <div class="bg-white p-5 rounded-2xl border border-emerald-200 shadow-sm bg-emerald-50/40">
            <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider block">Total Penerimaan (Lunas)</span>
            <span class="text-2xl font-black text-emerald-700 mt-2 block">Rp {{ number_format($ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</span>
            <span class="text-xs text-emerald-600 mt-1 block">{{ $ringkasanLaporan['total_sudah_bayar'] }} Transaksi Berhasil</span>
        </div>

        <!-- Total Piutang / Tunggakan -->
        <div class="bg-white p-5 rounded-2xl border border-amber-200 shadow-sm bg-amber-50/40">
            <span class="text-xs font-semibold text-amber-800 uppercase tracking-wider block">Total Menunggu Pembayaran</span>
            <span class="text-2xl font-black text-amber-700 mt-2 block">Rp {{ number_format($ringkasanLaporan['total_nominal_tagihan'] - $ringkasanLaporan['total_nominal_pembayaran'], 0, ',', '.') }}</span>
            <span class="text-xs text-amber-600 mt-1 block">{{ $ringkasanLaporan['total_belum_bayar'] }} Tagihan Tertunda</span>
        </div>
    </div>

    <!-- Detail Rincian Transaksi -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Detail Transaksi Laporan</h3>
            <span class="text-xs text-slate-500">{{ $daftarLaporan->total() }} data ditemukan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
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
                            <td class="px-5 py-3.5 text-center text-slate-400">
                                {{ $daftarLaporan->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-slate-900 block">{{ $trx->warga->nama_lengkap }}</span>
                                <span class="text-[11px] text-slate-400">Blok {{ $trx->warga->blok->nama_blok }} No. {{ $trx->warga->blok->nomor_rumah }} ({{ $trx->warga->blok->gang->nama_gang }})</span>
                            </td>
                            <td class="px-5 py-3.5 font-medium text-slate-800">
                                {{ $trx->jenisIuran->nama_iuran }}
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-700">
                                {{ $trx->periode }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($trx->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Lunas
                                    </span>
                                @elseif ($trx->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $trx->tanggal_pembayaran ? \Carbon\Carbon::parse($trx->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Tidak ada transaksi yang sesuai dengan filter laporan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($daftarLaporan->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $daftarLaporan->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
