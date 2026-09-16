@extends('layouts.dashboard')

@section('title', 'Dashboard Warga')
@section('page_heading', 'Portal Mandiri Warga')

@section('content')
<div class="space-y-8">

    <!-- Header Sambutan & Identitas Warga Login -->
    <div id="data-profil" class="bg-gradient-to-r from-emerald-900 to-teal-950 p-6 rounded-2xl text-white shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-200 border border-emerald-500/30 mb-2">
                Akun Warga: {{ auth()->user()->email }}
            </span>
            <h1 class="text-2xl font-bold tracking-tight">Selamat Datang, {{ $ringkasanWarga['nama_warga'] }}</h1>
            <p class="text-emerald-200 text-sm mt-1">
                Rumah: <span class="font-semibold text-white">{{ $ringkasanWarga['blok_dan_nomor'] }}</span> ({{ $ringkasanWarga['nama_gang'] }})
            </p>
        </div>

        <div class="bg-white/10 backdrop-blur-sm px-4 py-3 rounded-xl border border-white/10 text-right">
            <span class="text-xs text-emerald-200 block uppercase font-medium">Bulan Berjalan</span>
            <span class="text-lg font-bold font-mono tracking-wide text-white">{{ $periodeBulanIni }}</span>
        </div>
    </div>

    @if (!$warga)
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-sm flex items-center">
            <svg class="w-5 h-5 mr-3 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                Akun Anda belum ditautkan ke data profil warga. Hubungi pengurus RT/IPL untuk menghubungkan akun ini dengan unit rumah Anda.
            </div>
        </div>
    @endif

    <!-- 1. Ringkasan Tagihan Warga Login -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <!-- Total Tagihan Belum Dibayar -->
        <div class="bg-white p-5 rounded-xl border border-amber-200 shadow-sm bg-amber-50/40">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-amber-800 uppercase tracking-wider">Total Tagihan Belum Dibayar</p>
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            </div>
            <p class="text-3xl font-black text-amber-700 mt-2">
                {{ $ringkasanWarga['total_tagihan_belum_dibayar'] }}
            </p>
            <p class="text-xs text-amber-600 mt-1">Item tagihan belum diselesaikan</p>
        </div>

        <!-- Total Tagihan Sudah Dibayar -->
        <div class="bg-white p-5 rounded-xl border border-emerald-200 shadow-sm bg-emerald-50/40">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Total Tagihan Sudah Dibayar</p>
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
            </div>
            <p class="text-3xl font-black text-emerald-700 mt-2">
                {{ $ringkasanWarga['total_tagihan_sudah_dibayar'] }}
            </p>
            <p class="text-xs text-emerald-600 mt-1">Item tagihan berstatus lunas</p>
        </div>

        <!-- Total Nominal Tagihan Bulan Berjalan -->
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-5 rounded-xl border border-indigo-200 shadow-sm">
            <p class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Nominal Tagihan Bulan Ini ({{ $periodeBulanIni }})</p>
            <p class="text-3xl font-black text-indigo-900 mt-2">
                Rp {{ number_format($ringkasanWarga['nominal_tagihan_bulan_berjalan'], 0, ',', '.') }}
            </p>
            <p class="text-xs text-indigo-700 mt-1">Total iuran untuk periode aktif saat ini</p>
        </div>
    </div>

    <!-- 2. Tabel Iuran Saya -->
    <div id="tabel-iuran" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 sm:px-6 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-base font-bold text-slate-900">Iuran Saya</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar riwayat kewajiban iuran dan bukti pembayaran pribadi Anda</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-md">
                Data Pribadi Terenkripsi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100/70 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">Jenis Iuran</th>
                        <th class="px-6 py-3.5">Periode</th>
                        <th class="px-6 py-3.5">Nominal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($riwayatIuran as $iuran)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Jenis Iuran -->
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $iuran->jenisIuran->nama_iuran ?? '-' }}
                            </td>

                            <!-- Periode -->
                            <td class="px-6 py-4 font-mono text-xs text-slate-700">
                                {{ $iuran->periode }}
                            </td>

                            <!-- Nominal -->
                            <td class="px-6 py-4 font-bold text-slate-900">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-rose-500"></span>
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>

                            <!-- Tanggal Pembayaran -->
                            <td class="px-6 py-4 text-xs text-slate-500">
                                {{ $iuran->tanggal_pembayaran ? $iuran->tanggal_pembayaran->format('d/m/Y H:i') : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">
                                Belum ada riwayat iuran untuk akun Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
