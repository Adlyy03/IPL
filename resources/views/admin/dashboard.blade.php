@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Dashboard Administrator')

@section('content')
<div class="space-y-8">

    <!-- Header Sambutan -->
    <div class="bg-gradient-to-r from-slate-900 to-indigo-950 p-6 rounded-2xl text-white shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-500/20 text-indigo-200 border border-indigo-500/30 mb-2">
                Hak Akses: Administrator Sistem
            </span>
            <h1 class="text-2xl font-bold tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="text-slate-300 text-sm mt-1">
                Berikut ringkasan statistik master data kependudukan dan arus iuran warga perumahan.
            </p>
        </div>
        <div class="bg-white/10 backdrop-blur-sm px-4 py-3 rounded-xl border border-white/10 text-right">
            <span class="text-xs text-slate-300 block uppercase font-medium">Periode Aktif</span>
            <span class="text-lg font-bold font-mono tracking-wide text-white">{{ $periodeBulanIni }}</span>
        </div>
    </div>

    <!-- 1. Ringkasan Utama (7 Kartu Metrik) -->
    <div>
        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Ringkasan Utama Lingkungan & Tagihan
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Gang -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-slate-300 transition">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Gang</p>
                <p class="text-2xl font-black text-slate-900 mt-2">{{ $ringkasanUtama['total_gang'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Area jalan / gang</p>
            </div>

            <!-- Total Blok / Rumah -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-slate-300 transition">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Blok / Rumah</p>
                <p class="text-2xl font-black text-slate-900 mt-2">{{ $ringkasanUtama['total_blok'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Unit rumah tercatat</p>
            </div>

            <!-- Total Warga -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-slate-300 transition">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Warga</p>
                <p class="text-2xl font-black text-slate-900 mt-2">{{ $ringkasanUtama['total_warga'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Penduduk terdaftar</p>
            </div>

            <!-- Total Jenis Iuran -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:border-slate-300 transition">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Jenis Iuran</p>
                <p class="text-2xl font-black text-slate-900 mt-2">{{ $ringkasanUtama['total_jenis_iuran'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Master jenis retribusi</p>
            </div>

            <!-- Total Iuran Belum Dibayar -->
            <div class="bg-white p-5 rounded-xl border border-amber-200 shadow-sm bg-amber-50/40">
                <p class="text-xs font-semibold text-amber-800 uppercase tracking-wider">Iuran Belum Dibayar</p>
                <p class="text-2xl font-black text-amber-700 mt-2">{{ $ringkasanUtama['total_iuran_belum_dibayar'] }}</p>
                <p class="text-xs text-amber-600 mt-1">Transaksi pending</p>
            </div>

            <!-- Total Iuran Sudah Dibayar -->
            <div class="bg-white p-5 rounded-xl border border-emerald-200 shadow-sm bg-emerald-50/40">
                <p class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Iuran Sudah Dibayar</p>
                <p class="text-2xl font-black text-emerald-700 mt-2">{{ $ringkasanUtama['total_iuran_sudah_dibayar'] }}</p>
                <p class="text-xs text-emerald-600 mt-1">Transaksi lunas</p>
            </div>

            <!-- Total Nominal Iuran Bulan Berjalan -->
            <div class="col-span-2 bg-gradient-to-br from-indigo-50 to-blue-50 p-5 rounded-xl border border-indigo-200 shadow-sm">
                <p class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Nominal Iuran Bulan Berjalan ({{ $periodeBulanIni }})</p>
                <p class="text-2xl sm:text-3xl font-black text-indigo-900 mt-2">
                    Rp {{ number_format($ringkasanUtama['nominal_iuran_bulan_berjalan'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-indigo-700 mt-1">Total tagihan terbit pada periode aktif</p>
            </div>
        </div>
    </div>

    <!-- 2. Bagian Ringkasan Pembayaran -->
    <div>
        <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Ringkasan Pembayaran
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Jumlah Sudah Bayar -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase">Jumlah Sudah Bayar</span>
                <p class="text-2xl font-black text-emerald-600 mt-2">{{ $ringkasanPembayaran['jumlah_sudah_bayar'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Kuitansi / pembayaran sah</p>
            </div>

            <!-- Jumlah Belum Bayar -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase">Jumlah Belum Bayar</span>
                <p class="text-2xl font-black text-amber-600 mt-2">{{ $ringkasanPembayaran['jumlah_belum_bayar'] }}</p>
                <p class="text-xs text-slate-400 mt-1">Menunggu penyelesaian</p>
            </div>

            <!-- Total Nominal Pembayaran -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase">Total Nominal Pembayaran</span>
                <p class="text-2xl font-black text-emerald-700 mt-2">
                    Rp {{ number_format($ringkasanPembayaran['total_nominal_pembayaran'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Uang masuk ke kas IPL</p>
            </div>

            <!-- Total Tagihan -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-xs font-semibold text-slate-500 uppercase">Total Tagihan</span>
                <p class="text-2xl font-black text-slate-900 mt-2">
                    Rp {{ number_format($ringkasanPembayaran['total_tagihan'], 0, ',', '.') }}
                </p>
                <p class="text-xs text-slate-400 mt-1">Akumulasi seluruh tagihan</p>
            </div>
        </div>
    </div>

    <!-- 3. Bagian Iuran Terbaru -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 sm:px-6 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-base font-bold text-slate-900">Iuran Terbaru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar transaksi iuran yang tercatat secara real-time</p>
            </div>
            <span class="text-xs font-medium px-2.5 py-1 bg-slate-200 text-slate-700 rounded-md">
                {{ $iuranTerbaru->count() }} Data Terbaru
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100/70 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">Nama Warga</th>
                        <th class="px-6 py-3.5">Blok / Nomor</th>
                        <th class="px-6 py-3.5">Jenis Iuran</th>
                        <th class="px-6 py-3.5">Periode</th>
                        <th class="px-6 py-3.5">Nominal</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Tanggal Pembayaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($iuranTerbaru as $iuran)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Nama Warga -->
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ $iuran->warga->nama_lengkap ?? '-' }}
                            </td>

                            <!-- Blok/Nomor -->
                            <td class="px-6 py-4 text-xs text-slate-600">
                                <span class="font-medium text-slate-800">
                                    {{ $iuran->warga->blok->nama_blok ?? '-' }} No. {{ $iuran->warga->blok->nomor_rumah ?? '-' }}
                                </span>
                                <span class="block text-[11px] text-slate-400">
                                    {{ $iuran->warga->blok->gang->nama_gang ?? '' }}
                                </span>
                            </td>

                            <!-- Jenis Iuran -->
                            <td class="px-6 py-4 font-medium text-slate-700">
                                {{ $iuran->jenisIuran->nama_iuran ?? '-' }}
                            </td>

                            <!-- Periode -->
                            <td class="px-6 py-4 font-mono text-xs text-slate-600">
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
                                        Menunggu
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
                            <td colspan="7" class="px-6 py-10 text-center text-slate-400 text-sm">
                                Belum ada transaksi iuran tercatat di database.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
