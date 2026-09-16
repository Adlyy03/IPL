@extends('layouts.dashboard')

@section('title', 'Detail Jenis Iuran: ' . $jenisIuran->nama_iuran)
@section('page_heading', 'Detail Master Jenis Iuran')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('admin.jenis-iuran.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Master Iuran
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-xs">
                    Rp
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $jenisIuran->nama_iuran }}</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10.5">Retribusi dengan tarif standar <span class="font-bold text-slate-800 font-mono">Rp {{ number_format($jenisIuran->nominal, 0, ',', '.') }}</span> per periode.</p>
        </div>
        <div class="flex items-center gap-2 pl-10.5 sm:pl-0">
            <a href="{{ route('admin.jenis-iuran.edit', $jenisIuran) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl border border-indigo-100 transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.iuran-warga.generate', ['jenis_iuran_id' => $jenisIuran->id]) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Generate Tagihan Massal
            </a>
        </div>
    </div>

    <!-- Info Detail Grid & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Rincian Iuran -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs lg:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Rincian Jenis Iuran</h2>
                </div>
                @if ($jenisIuran->is_aktif)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Digunakan
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Nonaktif
                    </span>
                @endif
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nama Iuran</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $jenisIuran->nama_iuran }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nominal Standar</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm font-mono">Rp {{ number_format($jenisIuran->nominal, 0, ',', '.') }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Status Penggunaan</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $jenisIuran->is_aktif ? 'Aktif' : 'Nonaktif' }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Total Tagihan Diterbitkan</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm font-mono">{{ $jenisIuran->iuranWargas->count() }} Record</dd>
                </div>
                <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Deskripsi / Peruntukan</dt>
                    <dd class="text-slate-700 mt-1 leading-relaxed">{{ $jenisIuran->deskripsi ?: 'Tidak ada keterangan khusus.' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Ringkasan Finansial Singkat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Statistik Tagihan</h2>
                </div>
                <div class="space-y-3">
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                        <span class="text-xs text-slate-500 block font-medium">Total Tagihan Diterbitkan</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-black text-slate-900 font-mono">{{ $jenisIuran->iuranWargas->count() }}</span>
                            <span class="text-xs font-medium text-slate-500">Tagihan</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-100/70">
                        <span class="text-xs text-emerald-700 block font-medium">Tagihan Lunas</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-black text-emerald-700 font-mono">{{ $jenisIuran->iuranWargas->where('status_pembayaran', 'lunas')->count() }}</span>
                            <span class="text-xs font-medium text-emerald-600">Invoice</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-100/70">
                        <span class="text-xs text-amber-700 block font-medium">Tagihan Belum Lunas</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-black text-amber-700 font-mono">{{ $jenisIuran->iuranWargas->where('status_pembayaran', 'menunggu_pembayaran')->count() }}</span>
                            <span class="text-xs font-medium text-amber-600">Invoice</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100">
                <span class="text-[11px] text-slate-400 block">Dihitung otomatis dari seluruh siklus tagihan yang mengacu pada jenis iuran ini.</span>
            </div>
        </div>
    </div>

    <!-- Tabel Tagihan Terakhir -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/90 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Tagihan Terakhir untuk Jenis Iuran Ini</h3>
                <p class="text-xs text-slate-500 mt-0.5">20 transaksi terbaru yang menggunakan kategori iuran ini</p>
            </div>
            <a href="{{ route('admin.iuran-warga.index', ['jenis_iuran_id' => $jenisIuran->id]) }}"
               class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition gap-1">
                <span>Lihat di Transaksi</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Warga</th>
                        <th class="px-5 py-3.5">Periode</th>
                        <th class="px-5 py-3.5">Nominal</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5">Tgl Pembayaran</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jenisIuran->iuranWargas->sortByDesc('id')->take(20) as $index => $iuran)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.warga.show', $iuran->warga) }}" class="hover:text-indigo-600 transition inline-flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-[11px]">
                                        {{ substr($iuran->warga->nama_lengkap, 0, 1) }}
                                    </span>
                                    <span>{{ $iuran->warga->nama_lengkap }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-700">
                                <span class="bg-slate-100 px-2 py-0.5 rounded text-[11px] font-semibold">{{ $iuran->periode }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 font-mono">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono text-[11px]">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center">
                                <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-slate-600">Belum ada transaksi tagihan untuk jenis iuran ini</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Tagihan akan tampil di sini setelah digenerate atau dibuat secara mandiri.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
