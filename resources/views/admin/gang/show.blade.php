@extends('layouts.dashboard')

@section('title', 'Detail Gang: ' . $gang->nama_gang)
@section('page_heading', 'Detail Data Gang')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.gang.index') }}" class="inline-flex items-center gap-1.5 text-xs text-indigo-600 hover:text-indigo-800 font-semibold mb-1 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Daftar Gang</span>
            </a>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $gang->nama_gang }}</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Informasi detail gang beserta blok dan rumah di bawah naungannya.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.gang.edit', $gang) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100/80 border border-indigo-200/70 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Data</span>
            </a>
            <a href="{{ route('admin.blok.create') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Blok di Gang Ini</span>
            </a>
        </div>
    </div>

    <!-- Info Detail Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Informasi Gang Card -->
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs md:col-span-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Informasi Umum Gang</span>
            </h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                <div>
                    <dt class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Nama Gang</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-base">{{ $gang->nama_gang }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Status Operasional</dt>
                    <dd class="mt-1">
                        @if ($gang->status === 'aktif')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Nonaktif
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Keterangan Tambahan</dt>
                    <dd class="text-slate-700 mt-1 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100 font-medium">
                        {{ $gang->keterangan ?: 'Tidak ada keterangan tambahan yang dicatat untuk gang ini.' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Didaftarkan Pada</dt>
                    <dd class="text-slate-700 mt-1 font-medium">{{ $gang->created_at ? $gang->created_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-semibold uppercase tracking-wider text-[10px]">Terakhir Diperbarui</dt>
                    <dd class="text-slate-700 mt-1 font-medium">{{ $gang->updated_at ? $gang->updated_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Statistik Terkait Card -->
        <div class="bg-white p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span>Statistik Wilayah</span>
            </h3>
            <div class="space-y-3">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-500 block font-semibold">Total Unit Rumah / Blok</span>
                    <span class="text-3xl font-black text-slate-900 mt-1 block tracking-tight">{{ $gang->bloks->count() }} <span class="text-xs font-normal text-slate-500">Unit</span></span>
                </div>
                <div class="p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100/60">
                    <span class="text-xs text-indigo-900 block font-semibold">Total Warga Penghuni</span>
                    <span class="text-3xl font-black text-indigo-600 mt-1 block tracking-tight">{{ $gang->bloks->sum('wargas_count') }} <span class="text-xs font-normal text-indigo-500">Jiwa</span></span>
                </div>
            </div>
            <div class="pt-4 border-t border-slate-100 mt-4 text-[11px] text-slate-400">
                Data terakumulasi dari seluruh unit hunian aktif di gang ini.
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Blok di Gang Ini -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200/80 flex items-center justify-between bg-slate-50/50">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Blok & Rumah di {{ $gang->nama_gang }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Semua unit rumah yang terdaftar di bawah gang ini</p>
            </div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-slate-200/70 text-slate-700 rounded-lg">
                {{ $gang->bloks->count() }} Unit Terdaftar
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-3.5 w-14 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Blok</th>
                        <th class="px-5 py-3.5">Nomor Rumah</th>
                        <th class="px-5 py-3.5 text-center">Status Blok</th>
                        <th class="px-5 py-3.5 text-center">Jumlah Penghuni</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($gang->bloks as $index => $blok)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-5 py-4 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-bold text-slate-900 text-sm">
                                <a href="{{ route('admin.blok.show', $blok) }}" class="hover:text-indigo-600 transition">
                                    {{ $blok->nama_blok }}
                                </a>
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-700">No. {{ $blok->nomor_rumah }}</td>
                            <td class="px-5 py-4 text-center">
                                @if ($blok->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $blok->wargas_count }} Orang
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.blok.show', $blok) }}"
                                       class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200/80 rounded-lg transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.blok.edit', $blok) }}"
                                       class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100/80 rounded-lg transition">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <p class="text-xs text-slate-500">Belum ada blok atau rumah yang terdaftar di gang ini.</p>
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
