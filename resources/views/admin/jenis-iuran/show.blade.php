@extends('layouts.dashboard')

@section('title', 'Detail Jenis Iuran: ' . $jenisIuran->nama_iuran)
@section('page_heading', 'Detail Master Jenis Iuran')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.jenis-iuran.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">&larr; Kembali ke Master Iuran</a>
            </div>
            <h1 class="text-xl font-bold text-slate-900 mt-1">{{ $jenisIuran->nama_iuran }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Retribusi dengan tarif standar Rp {{ number_format($jenisIuran->nominal, 0, ',', '.') }}.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.jenis-iuran.edit', $jenisIuran) }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.iuran-warga.generate', ['jenis_iuran_id' => $jenisIuran->id]) }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Generate Tagihan Massal
            </a>
        </div>
    </div>

    <!-- Info Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Rincian Iuran -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm md:col-span-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Rincian Jenis Iuran</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="text-slate-500 font-medium">Nama Iuran</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $jenisIuran->nama_iuran }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Nominal Standar</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">Rp {{ number_format($jenisIuran->nominal, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Status Penggunaan</dt>
                    <dd class="mt-1">
                        @if ($jenisIuran->is_aktif)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Aktif Digunakan
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-500 font-medium">Deskripsi / Peruntukan</dt>
                    <dd class="text-slate-700 mt-1 leading-relaxed">{{ $jenisIuran->deskripsi ?: 'Tidak ada keterangan khusus.' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Ringkasan Finansial Singkat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Statistik Tagihan</h2>
            <div class="space-y-3">
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-[11px] text-slate-500 block">Total Tagihan Diterbitkan</span>
                    <span class="text-xl font-bold text-slate-900">{{ $jenisIuran->iuranWargas->count() }} Tagihan</span>
                </div>
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                    <span class="text-[11px] text-emerald-700 block">Tagihan Lunas</span>
                    <span class="text-xl font-bold text-emerald-700">{{ $jenisIuran->iuranWargas->where('status_pembayaran', 'lunas')->count() }}</span>
                </div>
                <div class="p-3 rounded-xl bg-amber-50 border border-amber-100">
                    <span class="text-[11px] text-amber-700 block">Tagihan Belum Lunas</span>
                    <span class="text-xl font-bold text-amber-700">{{ $jenisIuran->iuranWargas->where('status_pembayaran', 'menunggu_pembayaran')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Tagihan Terakhir -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Tagihan Terakhir untuk Jenis Iuran Ini</h3>
            <a href="{{ route('admin.iuran-warga.index', ['jenis_iuran_id' => $jenisIuran->id]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                Lihat di Transaksi &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
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
                            <td class="px-5 py-3.5 text-center text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.warga.show', $iuran->warga) }}" class="hover:text-indigo-600">
                                    {{ $iuran->warga->nama_lengkap }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-700">
                                {{ $iuran->periode }}
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Rp {{ number_format($iuran->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($iuran->status_pembayaran === 'lunas')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Lunas
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada transaksi tagihan untuk jenis iuran ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
