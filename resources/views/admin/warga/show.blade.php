@extends('layouts.dashboard')

@section('title', 'Detail Warga: ' . $warga->nama_lengkap)
@section('page_heading', 'Detail Data Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.warga.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">&larr; Kembali ke Daftar Warga</a>
            </div>
            <h1 class="text-xl font-bold text-slate-900 mt-1">{{ $warga->nama_lengkap }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Penghuni di Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}, {{ $warga->blok->gang->nama_gang }}.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.warga.edit', $warga) }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Warga
            </a>
            <a href="{{ route('admin.iuran-warga.create', ['warga_id' => $warga->id]) }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Tagihan Iuran
            </a>
        </div>
    </div>

    <!-- Info Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Biodata Warga -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm md:col-span-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Biodata Warga</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="text-slate-500 font-medium">Nama Lengkap</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $warga->nama_lengkap }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">NIK (KTP)</dt>
                    <dd class="text-slate-900 font-mono mt-1">{{ $warga->nik ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Nomor HP / WhatsApp</dt>
                    <dd class="text-slate-900 font-mono mt-1">{{ $warga->nomor_hp ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Peran dalam Keluarga</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                            {{ ucwords(str_replace('_', ' ', $warga->peran_keluarga)) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Status Kependudukan</dt>
                    <dd class="mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $warga->status_warga === 'tetap' ? 'bg-sky-100 text-sky-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ ucfirst($warga->status_warga) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Status Keaktifan</dt>
                    <dd class="mt-1">
                        @if ($warga->is_aktif)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Aktif Berdomisili
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                Nonaktif / Pindah
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Info Hunian & Summary -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Rumah</h2>
                <div class="space-y-2 text-xs">
                    <p class="text-slate-500">Blok & Nomor:</p>
                    <p class="text-base font-bold text-slate-900">Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}</p>
                    <p class="text-slate-500 mt-2">Gang / Area:</p>
                    <p class="text-sm font-semibold text-indigo-600">{{ $warga->blok->gang->nama_gang }}</p>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 mt-4">
                <span class="text-[11px] text-slate-400 block">Total Tagihan Iuran:</span>
                <span class="text-xl font-black text-slate-900">{{ $warga->iuranWargas->count() }} Tagihan</span>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Iuran Warga -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Riwayat Iuran & Pembayaran Warga</h3>
            <span class="text-xs text-slate-500">{{ $warga->iuranWargas->count() }} transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Jenis Iuran</th>
                        <th class="px-5 py-3.5">Periode</th>
                        <th class="px-5 py-3.5">Nominal</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5">Tgl Pembayaran</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($warga->iuranWargas->sortByDesc('periode') as $index => $iuran)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">{{ $iuran->jenisIuran->nama_iuran }}</td>
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
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-800">
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.iuran-warga.show', $iuran) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada riwayat iuran untuk warga ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
