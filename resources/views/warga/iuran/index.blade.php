@extends('layouts.dashboard')

@section('title', 'Riwayat Iuran Saya')
@section('page_heading', 'Riwayat & Tagihan Iuran')

@section('content')
<div class="space-y-6">

    <!-- Header & Unit Identity -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Daftar Tagihan Iuran Anda</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Pantau seluruh kewajiban iuran lingkungan bulanan dan bukti pembayaran resmi.</p>
        </div>

        <div class="pl-10 sm:pl-0 text-left sm:text-right">
            <span class="text-[11px] text-slate-400 block font-medium">Unit Tempat Tinggal:</span>
            <span class="text-xs font-bold text-slate-800 bg-white px-3 py-1.5 rounded-xl border border-slate-200 inline-block mt-0.5">
                @if ($warga)
                    {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }} &bull; {{ $warga->blok->gang->nama_gang }}
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
                Akun Anda belum ditautkan ke data kependudukan warga. Silakan hubungi pengurus RT/RW untuk menghubungkan akun ini dengan unit rumah Anda.
            </div>
        </div>
    @else

        <!-- 4 KPI Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Total Tagihan</span>
                <p class="text-xl sm:text-2xl font-bold text-slate-900 mt-1">{{ $ringkasan['total_tagihan'] }}</p>
                <span class="text-[10px] text-slate-500 mt-0.5 block">Kewajiban terbit</span>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-amber-200/90 shadow-2xs bg-amber-50/20">
                <span class="text-[11px] font-semibold text-amber-700 uppercase tracking-wider block">Belum Dibayar</span>
                <p class="text-xl sm:text-2xl font-bold text-amber-600 mt-1">{{ $ringkasan['total_belum_bayar'] }}</p>
                <span class="text-[10px] text-amber-700/80 mt-0.5 block">Menunggu verifikasi</span>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-emerald-200/90 shadow-2xs bg-emerald-50/20">
                <span class="text-[11px] font-semibold text-emerald-700 uppercase tracking-wider block">Sudah Lunas</span>
                <p class="text-xl sm:text-2xl font-bold text-emerald-600 mt-1">{{ $ringkasan['total_lunas'] }}</p>
                <span class="text-[10px] text-emerald-700/80 mt-0.5 block">Tercatat di sistem</span>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-indigo-200/90 shadow-2xs bg-indigo-50/20">
                <span class="text-[11px] font-semibold text-indigo-700 uppercase tracking-wider block">Total Terfilter</span>
                <p class="text-lg sm:text-xl font-bold text-indigo-950 mt-1">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                <span class="text-[10px] text-indigo-600 mt-0.5 block">Nominal query aktif</span>
            </div>
        </div>

        <!-- Filter & Pencarian -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <form method="GET" action="{{ route('warga.iuran.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">
                <!-- Search Keyword -->
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Cari Tagihan</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari periode atau jenis..."
                               class="w-full text-xs rounded-xl border border-slate-300 py-2.5 pl-9 pr-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

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
                        <option value="">Semua Jenis Iuran</option>
                        @foreach ($jenisIurans as $jenis)
                            <option value="{{ $jenis->id }}" {{ (string)request('jenis_iuran_id') === (string)$jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_iuran }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Bayar</label>
                    <select name="status_pembayaran" class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        <option value="">Semua Status</option>
                        <option value="menunggu_pembayaran" {{ request('status_pembayaran') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu</option>
                        <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="batal" {{ request('status_pembayaran') === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="lg:col-span-1 flex items-end gap-1.5">
                    <button type="submit"
                            title="Terapkan filter"
                            class="w-full py-2.5 px-3 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition shadow-2xs text-center">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'periode', 'jenis_iuran_id', 'status_pembayaran']))
                        <a href="{{ route('warga.iuran.index') }}"
                           title="Reset filter"
                           class="py-2.5 px-3 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            ✕
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="px-5 py-3.5 text-center w-12">No</th>
                            <th class="px-5 py-3.5">Kode Tagihan</th>
                            <th class="px-5 py-3.5">Jenis Iuran</th>
                            <th class="px-5 py-3.5">Periode</th>
                            <th class="px-5 py-3.5 text-right">Nominal (Rp)</th>
                            <th class="px-5 py-3.5 text-center">Status</th>
                            <th class="px-5 py-3.5">Tanggal Pembayaran</th>
                            <th class="px-5 py-3.5 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($daftarIuran as $index => $iuran)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-5 py-3.5 text-center text-slate-400">
                                    {{ $daftarIuran->firstItem() ? ($daftarIuran->firstItem() + $index) : ($index + 1) }}
                                </td>
                                <td class="px-5 py-3.5 font-mono text-[11px] font-bold text-slate-700">
                                    #IPL-{{ str_pad($iuran->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900">
                                    {{ $iuran->jenisIuran?->nama_iuran ?? 'Iuran Lingkungan' }}
                                </td>
                                <td class="px-5 py-3.5 font-mono text-slate-700">
                                    {{ $iuran->periode }}
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900 text-right">
                                    Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($iuran->status_pembayaran === 'lunas')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Lunas
                                        </span>
                                    @elseif ($iuran->status_pembayaran === 'batal')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Batal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-slate-600">
                                    {{ $iuran->tanggal_pembayaran ? $iuran->tanggal_pembayaran->translatedFormat('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <a href="{{ route('warga.iuran.show', $iuran->id) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100/80 rounded-lg transition">
                                        Rincian &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="font-medium text-slate-600 text-xs">Tidak ditemukan data tagihan iuran.</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Coba ubah kata kunci atau reset filter pencarian Anda.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($daftarIuran->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $daftarIuran->links() }}
                </div>
            @endif
        </div>

        <!-- Mobile Card List View -->
        <div class="md:hidden space-y-3">
            @forelse ($daftarIuran as $iuran)
                <div class="bg-white p-4 rounded-2xl border border-slate-200/90 shadow-2xs space-y-3">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-slate-400 block">#IPL-{{ str_pad($iuran->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="text-sm font-bold text-slate-900 mt-0.5">{{ $iuran->jenisIuran?->nama_iuran ?? 'Iuran Lingkungan' }}</h3>
                            <span class="text-xs text-slate-500 font-mono">Periode: {{ $iuran->periode }}</span>
                        </div>

                        @if ($iuran->status_pembayaran === 'lunas')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Lunas
                            </span>
                        @elseif ($iuran->status_pembayaran === 'batal')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                Batal
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                Menunggu
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Nominal Tagihan:</span>
                            <span class="text-sm font-bold text-slate-900">Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('warga.iuran.show', $iuran->id) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                            Lihat Rincian &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-400">
                    <p class="text-xs font-semibold text-slate-700">Tidak ada data tagihan</p>
                    <p class="text-[11px] text-slate-400 mt-1">Coba sesuaikan filter Anda.</p>
                </div>
            @endforelse

            @if ($daftarIuran->hasPages())
                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                    {{ $daftarIuran->links() }}
                </div>
            @endif
        </div>

        <!-- Petunjuk & Rekening Pembayaran -->
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 text-xs text-slate-600 space-y-2">
            <h4 class="font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tata Cara Pembayaran Tagihan Lingkungan
            </h4>
            <p class="leading-relaxed">
                Pembayaran iuran dapat disetorkan langsung ke bendahara RT atau transfer ke rekening resmi RT/RW: <strong>BCA 123-456-7890 a.n. Kas Pengelola Lingkungan</strong>. Setelah bukti pembayaran diserahkan atau diverifikasi pengurus, status tagihan otomatis berubah menjadi <strong>Lunas</strong>.
            </p>
        </div>

    @endif
</div>
@endsection
