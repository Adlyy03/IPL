@extends('layouts.dashboard')

@section('title', 'Dashboard Warga')
@section('page_heading', 'Portal Mandiri Warga')

@section('content')
<div class="space-y-6">

    <!-- Notifikasi Banner: Tagihan Belum Dibayar -->
    @if ($tagihanBelumBayar->isNotEmpty())
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-500/10 border border-amber-300/80 text-amber-950 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
            <div class="flex items-start gap-3.5">
                <div class="p-2.5 rounded-xl bg-amber-500 text-white shrink-0 shadow-sm shadow-amber-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-bold text-amber-950">Peringatan Kewajiban Iuran</h2>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-200 text-amber-900">
                            {{ $ringkasanWarga['total_tagihan_belum_dibayar'] }} Tagihan Tertunda
                        </span>
                    </div>
                    <p class="text-xs text-amber-800 mt-1 leading-relaxed">
                        Anda memiliki tagihan iuran yang belum dibayar dengan total kewajiban sebesar 
                        <strong class="font-bold text-amber-950">Rp {{ number_format($ringkasanWarga['nominal_belum_dibayar'], 0, ',', '.') }}</strong>.
                        Harap segera lakukan pembayaran untuk kelancaran fasilitas lingkungan.
                    </p>
                </div>
            </div>
            <div class="sm:shrink-0 pl-11 sm:pl-0">
                <a href="{{ route('warga.iuran.index', ['status_pembayaran' => 'menunggu_pembayaran']) }}"
                   class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition">
                    Lihat dan Bayar Tagihan &rarr;
                </a>
            </div>
        </div>
    @endif

    <!-- Header Sambutan & Identitas Warga Login -->
    <div id="data-profil" class="bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-7 rounded-2xl text-white shadow-md border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="flex items-start sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-xl font-bold shadow-md shadow-indigo-500/30 ring-4 ring-white/10 shrink-0">
                {{ strtoupper(substr($ringkasanWarga['nama_warga'], 0, 2)) }}
            </div>
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        Warga Terdaftar
                    </span>
                    <span class="text-xs text-slate-400 font-mono">{{ auth()->user()->email }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white">
                    Selamat Datang, {{ $ringkasanWarga['nama_warga'] }}
                </h1>
                <p class="text-xs text-indigo-200/90 mt-1 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Unit Hunian: <strong class="text-white font-semibold">{{ $ringkasanWarga['blok_dan_nomor'] }}</strong> ({{ $ringkasanWarga['nama_gang'] }})</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 self-start md:self-auto bg-white/10 backdrop-blur-md px-4 py-3 rounded-xl border border-white/10">
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300 block">Periode Berjalan</span>
                <span class="text-sm font-bold font-mono tracking-wide text-white">{{ $periodeBulanIni }}</span>
            </div>
            <a href="{{ route('warga.profil.show') }}"
               class="px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600/80 hover:bg-indigo-600 rounded-lg border border-indigo-400/30 transition">
                Profil &rarr;
            </a>
        </div>
    </div>

    @if (!$warga)
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                Akun Anda belum ditautkan ke data profil warga. Hubungi pengurus RT/IPL untuk menghubungkan akun ini dengan unit rumah Anda.
            </div>
        </div>
    @endif

    <!-- 4 KPI Summary Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Belum Dibayar -->
        <div class="bg-white p-5 rounded-2xl border border-amber-200/90 shadow-2xs bg-amber-50/20">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-amber-800 uppercase tracking-wider">Belum Dibayar</span>
                <span class="p-1.5 rounded-lg bg-amber-100 text-amber-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-amber-600 mt-2">
                {{ $ringkasanWarga['total_tagihan_belum_dibayar'] }}
            </p>
            <p class="text-xs text-amber-700/90 mt-1 font-semibold">
                Rp {{ number_format($ringkasanWarga['nominal_belum_dibayar'], 0, ',', '.') }}
            </p>
        </div>

        <!-- Total Sudah Dibayar (Lunas) -->
        <div class="bg-white p-5 rounded-2xl border border-emerald-200/90 shadow-2xs bg-emerald-50/20">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-emerald-800 uppercase tracking-wider">Sudah Lunas</span>
                <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-emerald-600 mt-2">
                {{ $ringkasanWarga['total_tagihan_sudah_dibayar'] }}
            </p>
            <p class="text-xs text-emerald-700/90 mt-1 font-semibold">
                Rp {{ number_format($ringkasanWarga['nominal_sudah_dibayar'], 0, ',', '.') }}
            </p>
        </div>

        <!-- Nominal Bulan Berjalan -->
        <div class="bg-white p-5 rounded-2xl border border-indigo-200/90 shadow-2xs bg-indigo-50/20">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-indigo-900 uppercase tracking-wider">Bulan Ini ({{ $periodeBulanIni }})</span>
                <span class="p-1.5 rounded-lg bg-indigo-100 text-indigo-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-indigo-950 mt-2">
                Rp {{ number_format($ringkasanWarga['nominal_tagihan_bulan_berjalan'], 0, ',', '.') }}
            </p>
            <p class="text-xs text-indigo-600 mt-1">Kewajiban periode berjalan</p>
        </div>

        <!-- Total Riwayat Tagihan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-2xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">Total Tagihan</span>
                <span class="p-1.5 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
            </div>
            <p class="text-2xl font-bold text-slate-900 mt-2">
                {{ $ringkasanWarga['total_tagihan'] }}
            </p>
            <p class="text-xs text-slate-500 mt-1">Keseluruhan catatan iuran</p>
        </div>
    </div>

    <!-- Riwayat Tagihan Terakhir -->
    <div id="tabel-iuran" class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="p-5 sm:px-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <h2 class="text-sm sm:text-base font-bold text-slate-900">Riwayat Tagihan & Pembayaran Saya</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar kewajiban iuran IPL yang tercatat untuk akun Anda</p>
            </div>
            <a href="{{ route('warga.iuran.index') }}"
               class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
                Lihat Semua Tagihan &rarr;
            </a>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">Kode</th>
                        <th class="px-6 py-3.5">Jenis Iuran</th>
                        <th class="px-6 py-3.5">Periode</th>
                        <th class="px-6 py-3.5 text-right">Nominal (Rp)</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5">Tanggal Bayar</th>
                        <th class="px-6 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($riwayatIuran->take(6) as $iuran)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-mono font-bold text-slate-700">
                                #IPL-{{ str_pad($iuran->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">
                                {{ $iuran->jenisIuran->nama_iuran ?? '-' }}
                            </td>
                            <td class="px-6 py-4 font-mono text-slate-700">
                                {{ $iuran->periode }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900 text-right">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $iuran->tanggal_pembayaran ? $iuran->tanggal_pembayaran->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('warga.iuran.show', $iuran->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Rincian
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                                Belum ada riwayat iuran untuk akun Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List -->
        <div class="md:hidden divide-y divide-slate-100">
            @forelse ($riwayatIuran->take(6) as $iuran)
                <div class="p-4 space-y-2.5 hover:bg-slate-50/60 transition">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-mono font-bold text-slate-400">#IPL-{{ str_pad($iuran->id, 5, '0', STR_PAD_LEFT) }}</span>
                        @if ($iuran->status_pembayaran === 'lunas')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Lunas</span>
                        @elseif ($iuran->status_pembayaran === 'batal')
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Batal</span>
                        @else
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Menunggu</span>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-slate-900">{{ $iuran->jenisIuran->nama_iuran ?? '-' }}</h3>
                        <p class="text-[11px] text-slate-500 font-mono mt-0.5">Periode: {{ $iuran->periode }}</p>
                    </div>
                    <div class="flex items-center justify-between pt-1 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-900">Rp {{ number_format($iuran->nominal, 0, ',', '.') }}</span>
                        <a href="{{ route('warga.iuran.show', $iuran->id) }}"
                           class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            Lihat Rincian &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-xs text-slate-400">
                    Belum ada riwayat iuran untuk akun Anda.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
