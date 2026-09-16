@extends('layouts.dashboard')

@section('title', 'Riwayat Iuran Saya')
@section('page_heading', 'Riwayat Iuran Mandiri')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Riwayat & Tagihan Iuran Saya</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar tagihan retribusi lingkungan yang ditujukan ke hunian Anda.</p>
        </div>
        <div class="text-right">
            <span class="text-xs text-slate-400 block">Unit Rumah Anda:</span>
            <span class="text-sm font-bold text-slate-800">
                @if ($warga)
                    Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }} ({{ $warga->blok->gang->nama_gang }})
                @else
                    -
                @endif
            </span>
        </div>
    </div>

    @if (!$warga)
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                Akun Anda belum terhubung ke data kependudukan warga. Silakan hubungi pengurus lingkungan untuk mengaitkan akun Anda.
            </div>
        </div>
    @else
        <!-- Filter -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <form method="GET" action="{{ route('warga.iuran.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                <div class="sm:col-span-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Periode (YYYY-MM)</label>
                    <input type="text" name="periode" value="{{ request('periode') }}" placeholder="Contoh: 2026-09"
                           class="w-full text-xs rounded-xl border-slate-300 py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jenis Iuran</label>
                    <select name="jenis_iuran_id" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisIurans as $jenis)
                            <option value="{{ $jenis->id }}" {{ (string)request('jenis_iuran_id') === (string)$jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_iuran }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-3">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pembayaran</label>
                    <select name="status_pembayaran" class="w-full text-xs rounded-xl border-slate-300 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu</option>
                        <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="sm:col-span-2 flex items-end">
                    <button type="submit" class="w-full py-2 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Iuran Warga -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-5 py-3.5 w-12 text-center">No</th>
                            <th class="px-5 py-3.5">Jenis Iuran</th>
                            <th class="px-5 py-3.5">Periode Tagihan</th>
                            <th class="px-5 py-3.5">Nominal</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5">Tanggal Bayar</th>
                            <th class="px-5 py-3.5">Keterangan / Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($daftarIuran as $index => $iuran)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-5 py-3.5 text-center text-slate-400">
                                    {{ $daftarIuran->firstItem() + $index }}
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900">
                                    {{ $iuran->jenisIuran->nama_iuran }}
                                </td>
                                <td class="px-5 py-3.5 font-mono text-slate-700">
                                    {{ $iuran->periode }}
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900">
                                    Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($iuran->status_pembayaran === 'lunas')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                            &bull; Lunas
                                        </span>
                                    @elseif ($iuran->status_pembayaran === 'batal')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800">
                                            &bull; Batal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                            &bull; Menunggu Pembayaran
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-600">
                                    {{ $iuran->tanggal_pembayaran ? $iuran->tanggal_pembayaran->translatedFormat('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 italic">
                                    {{ $iuran->catatan ?: '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                    Belum ada tagihan iuran yang tercatat untuk akun Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($daftarIuran->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $daftarIuran->links() }}
                </div>
            @endif
        </div>

        <!-- Petunjuk Pembayaran -->
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 space-y-2">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Informasi & Tata Cara Pembayaran IPL
            </h4>
            <p class="leading-relaxed">
                Pembayaran iuran dapat dilakukan secara tunai kepada pengurus bendahara lingkungan atau melalui transfer perbankan ke rekening resmi pengurus RT/RW. Harap menyimpan bukti transaksi agar admin dapat memverifikasi status pembayaran Anda menjadi <strong>Lunas</strong>.
            </p>
        </div>
    @endif
</div>
@endsection
