@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Dashboard Administrator')

@section('content')
<div class="space-y-8">

    <!-- 1. Header Sambutan & Quick Context -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10 border border-slate-700/60">
        <!-- Subtle decorative background glow -->
        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-32 -bottom-20 w-80 h-80 rounded-full bg-blue-500/10 blur-3xl pointer-events-none" aria-hidden="true"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-200 border border-indigo-500/30 backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    <span>Hak Akses: Administrator Sistem</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang, {{ auth()->user()->name }}
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm max-w-2xl leading-relaxed">
                    Ringkasan kependudukan, kondisi hunian, dan rekapitulasi arus kas iuran warga perumahan secara real-time.
                </p>
            </div>

            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                <!-- Periode Aktif Pill -->
                <div class="bg-white/10 backdrop-blur-md px-4 py-3 rounded-2xl border border-white/15 text-left sm:text-right min-w-[140px]">
                    <span class="text-[10px] text-slate-400 block uppercase font-bold tracking-wider">Periode Aktif</span>
                    <span class="text-base sm:text-lg font-bold font-mono tracking-wide text-white">{{ $periodeBulanIni }}</span>
                </div>

                <!-- Quick Action Buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.iuran-warga.create') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-md shadow-indigo-600/30 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Tagihan Baru</span>
                    </a>
                    <a href="{{ route('admin.iuran-warga.generate') }}"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-200 hover:text-white bg-white/10 hover:bg-white/15 border border-white/15 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span>Generate</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Master Data Lingkungan (4 Kartu Metrik Utama) -->
    <div class="space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Master Data Lingkungan</span>
            </h2>
            <span class="text-xs text-slate-400">Terdaftar & Aktif</span>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Total Gang -->
            <a href="{{ route('admin.gang.index') }}"
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-indigo-300 transition duration-200 block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 group-hover:text-indigo-600 transition">Total Gang</span>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-indigo-50 text-slate-600 group-hover:text-indigo-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $ringkasanUtama['total_gang'] }}</p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <span>Ruas jalan / lorong</span>
                    <span class="text-indigo-500 opacity-0 group-hover:opacity-100 transition">&rarr;</span>
                </p>
            </a>

            <!-- Total Blok / Rumah -->
            <a href="{{ route('admin.blok.index') }}"
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-indigo-300 transition duration-200 block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 group-hover:text-indigo-600 transition">Total Rumah</span>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-indigo-50 text-slate-600 group-hover:text-indigo-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $ringkasanUtama['total_blok'] }}</p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <span>Unit hunian terdata</span>
                    <span class="text-indigo-500 opacity-0 group-hover:opacity-100 transition">&rarr;</span>
                </p>
            </a>

            <!-- Total Warga -->
            <a href="{{ route('admin.warga.index') }}"
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-indigo-300 transition duration-200 block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 group-hover:text-indigo-600 transition">Total Warga</span>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-indigo-50 text-slate-600 group-hover:text-indigo-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $ringkasanUtama['total_warga'] }}</p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <span>Penduduk terdaftar</span>
                    <span class="text-indigo-500 opacity-0 group-hover:opacity-100 transition">&rarr;</span>
                </p>
            </a>

            <!-- Total Jenis Iuran -->
            <a href="{{ route('admin.jenis-iuran.index') }}"
               class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200/90 shadow-xs hover:shadow-md hover:border-indigo-300 transition duration-200 block">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-500 group-hover:text-indigo-600 transition">Jenis Iuran</span>
                    <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-indigo-50 text-slate-600 group-hover:text-indigo-600 flex items-center justify-center transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2 tracking-tight">{{ $ringkasanUtama['total_jenis_iuran'] }}</p>
                <p class="text-[11px] text-slate-400 mt-1 flex items-center gap-1">
                    <span>Master pos retribusi</span>
                    <span class="text-indigo-500 opacity-0 group-hover:opacity-100 transition">&rarr;</span>
                </p>
            </a>
        </div>
    </div>

    <!-- 3. Ringkasan Finansial & Arus Kas Iuran -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Ringkasan Pembayaran</span>
            </h2>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                Buka Laporan &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Tagihan Keseluruhan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Tagihan Akumulasi</span>
                    <p class="text-xl sm:text-2xl font-extrabold text-slate-900 mt-2 font-mono">
                        Rp {{ number_format($ringkasanPembayaran['total_tagihan'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="pt-3 border-t border-slate-100 mt-3 flex items-center justify-between text-xs text-slate-500">
                    <span>Semua tagihan terbit</span>
                    <span class="font-medium text-slate-700">{{ $ringkasanUtama['total_iuran_belum_dibayar'] + $ringkasanUtama['total_iuran_sudah_dibayar'] }} Trx</span>
                </div>
            </div>

            <!-- Sudah Dibayar (Lunas) -->
            <div class="bg-white p-5 rounded-2xl border border-emerald-200/80 shadow-xs bg-gradient-to-b from-white to-emerald-50/20 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider block">Sudah Dibayar (Lunas)</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    </div>
                    <p class="text-2xl font-black text-emerald-600 mt-2 tracking-tight">
                        {{ $ringkasanPembayaran['jumlah_sudah_bayar'] }} <span class="text-xs font-normal text-slate-500">Kuitansi</span>
                    </p>
                </div>
                <div class="pt-3 border-t border-emerald-100/60 mt-3 flex items-center justify-between text-xs text-emerald-700 font-medium">
                    <span>Kas Masuk Tercatat</span>
                    <span class="font-mono font-bold">Rp {{ number_format($ringkasanPembayaran['total_nominal_pembayaran'], 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Belum Dibayar (Pending) -->
            <div class="bg-white p-5 rounded-2xl border border-amber-200/80 shadow-xs bg-gradient-to-b from-white to-amber-50/20 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-amber-800 uppercase tracking-wider block">Belum Dibayar (Tertunda)</span>
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    </div>
                    <p class="text-2xl font-black text-amber-600 mt-2 tracking-tight">
                        {{ $ringkasanPembayaran['jumlah_belum_bayar'] }} <span class="text-xs font-normal text-slate-500">Tagihan</span>
                    </p>
                </div>
                <div class="pt-3 border-t border-amber-100/60 mt-3 flex items-center justify-between text-xs text-amber-800 font-medium">
                    <span>Sisa Piutang Warga</span>
                    <span class="font-mono font-bold">Rp {{ number_format(max(0, $ringkasanPembayaran['total_tagihan'] - $ringkasanPembayaran['total_nominal_pembayaran']), 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Nominal Iuran Bulan Berjalan -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white p-5 rounded-2xl border border-indigo-700/50 shadow-md shadow-indigo-900/10 flex flex-col justify-between">
                <div>
                    <span class="text-[11px] font-bold text-indigo-200 uppercase tracking-wider block">Iuran Bulan Berjalan</span>
                    <p class="text-xl sm:text-2xl font-extrabold text-white mt-2 font-mono">
                        Rp {{ number_format($ringkasanUtama['nominal_iuran_bulan_berjalan'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="pt-3 border-t border-indigo-700/40 mt-3 flex items-center justify-between text-xs text-indigo-200">
                    <span>Periode {{ $periodeBulanIni }}</span>
                    <a href="{{ route('admin.iuran-warga.index', ['periode' => $periodeBulanIni]) }}" class="text-indigo-300 hover:text-white font-semibold underline underline-offset-2">
                        Filter &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Daftar Iuran Terbaru -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-5 sm:px-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-slate-900">Transaksi Iuran Terbaru</h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-200/70 text-slate-700">
                        {{ $iuranTerbaru->count() }} Terakhir
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">Daftar transaksi penerbitan dan pembayaran iuran warga terkini.</p>
            </div>
            <a href="{{ route('admin.iuran-warga.index') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100/80 border border-indigo-200/70 rounded-xl transition self-start sm:self-auto">
                <span>Kelola Semua Iuran</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <!-- Desktop & Tablet Table with Horizontal Scroll -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200/80">
                    <tr>
                        <th class="px-6 py-3.5">Warga & Hunian</th>
                        <th class="px-6 py-3.5">Jenis Iuran</th>
                        <th class="px-6 py-3.5">Periode</th>
                        <th class="px-6 py-3.5 text-right">Nominal</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5">Tgl Pembayaran</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($iuranTerbaru as $iuran)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <!-- Nama Warga & Rumah -->
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.warga.show', $iuran->warga) }}" class="font-bold text-slate-900 hover:text-indigo-600 block text-sm">
                                    {{ $iuran->warga->nama_lengkap ?? '-' }}
                                </a>
                                <span class="text-[11px] text-slate-400 block mt-0.5">
                                    Blok {{ $iuran->warga->blok->nama_blok ?? '-' }} No. {{ $iuran->warga->blok->nomor_rumah ?? '-' }} ({{ $iuran->warga->blok->gang->nama_gang ?? '' }})
                                </span>
                            </td>

                            <!-- Jenis Iuran -->
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-800">
                                    {{ $iuran->jenisIuran->nama_iuran ?? '-' }}
                                </span>
                            </td>

                            <!-- Periode -->
                            <td class="px-6 py-4 font-mono font-semibold text-slate-700">
                                {{ $iuran->periode }}
                            </td>

                            <!-- Nominal -->
                            <td class="px-6 py-4 text-right font-mono font-bold text-slate-900 text-sm">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>

                            <!-- Tanggal Pembayaran -->
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $iuran->tanggal_pembayaran ? $iuran->tanggal_pembayaran->format('d/m/Y H:i') : '-' }}
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Transaksi Iuran</h4>
                                    <p class="text-xs text-slate-400">Belum terdapat riwayat penerbitan atau pembayaran iuran yang tercatat.</p>
                                    <div class="pt-2">
                                        <a href="{{ route('admin.iuran-warga.create') }}"
                                           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                                            Buat Tagihan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
