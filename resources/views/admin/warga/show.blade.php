@extends('layouts.dashboard')

@section('title', 'Detail Warga: ' . $warga->nama_lengkap)
@section('page_heading', 'Detail Data Warga')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('admin.warga.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Warga
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-xs">
                    {{ substr($warga->nama_lengkap, 0, 1) }}
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $warga->nama_lengkap }}</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10.5">Penghuni di Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}, {{ $warga->blok->gang->nama_gang }}.</p>
        </div>
        <div class="flex items-center gap-2 pl-10.5 sm:pl-0">
            <a href="{{ route('admin.warga.edit', $warga) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl border border-indigo-100 transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Warga
            </a>
            <a href="{{ route('admin.iuran-warga.create', ['warga_id' => $warga->id]) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Tagihan Iuran
            </a>
        </div>
    </div>

    <!-- Info Detail Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Biodata Warga -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs lg:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Biodata Warga</h2>
                </div>
                @if ($warga->is_aktif)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Berdomisili
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        Nonaktif / Pindah
                    </span>
                @endif
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nama Lengkap</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $warga->nama_lengkap }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">NIK (KTP)</dt>
                    <dd class="text-slate-900 font-mono mt-1 text-sm">{{ $warga->nik ?: '-' }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nomor HP / WhatsApp</dt>
                    <dd class="text-slate-900 font-mono mt-1 text-sm">{{ $warga->nomor_hp ?: '-' }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Peran dalam Keluarga</dt>
                    <dd class="mt-1.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            {{ ucwords(str_replace('_', ' ', $warga->peran_keluarga)) }}
                        </span>
                    </dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Status Kependudukan</dt>
                    <dd class="mt-1.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $warga->status_warga === 'tetap' ? 'bg-sky-50 text-sky-700 border border-sky-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                            {{ ucfirst($warga->status_warga) }}
                        </span>
                    </dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Status Keaktifan</dt>
                    <dd class="mt-1.5 font-semibold text-slate-800">
                        {{ $warga->is_aktif ? 'Aktif Berdomisili' : 'Nonaktif / Tidak Berdomisili' }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Info Hunian & Summary -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Informasi Hunian</h2>
                </div>
                <div class="space-y-3.5 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-slate-400 font-medium">Blok & Nomor Rumah</p>
                        <p class="text-base font-bold text-slate-900 mt-1">Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                        <p class="text-slate-400 font-medium">Gang / Area Lingkungan</p>
                        <p class="text-sm font-semibold text-indigo-600 mt-1 inline-flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $warga->blok->gang->nama_gang }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 mt-4">
                <div class="p-4 rounded-xl bg-indigo-50/50 border border-indigo-100/70 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-slate-500 block font-medium">Total Tagihan Iuran</span>
                        <span class="text-2xl font-black text-indigo-600 font-mono">{{ $warga->iuranWargas->count() }}</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-500">Invoice</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Iuran Warga -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/90 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Riwayat Iuran & Pembayaran Warga</h3>
                <p class="text-xs text-slate-500 mt-0.5">Daftar kewajiban tagihan dan status pelunasan iuran warga</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 w-fit">
                {{ $warga->iuranWargas->count() }} transaksi
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">{{ $iuran->jenisIuran->nama_iuran }}</td>
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
                                @elseif ($iuran->status_pembayaran === 'batal')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono text-[11px]">
                                {{ $iuran->tanggal_pembayaran ? \Carbon\Carbon::parse($iuran->tanggal_pembayaran)->locale('id')->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-slate-600">Belum ada riwayat iuran untuk warga ini</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Tagihan akan tampil di sini setelah digenerate atau dibuat secara manual.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
