@extends('layouts.dashboard')

@section('title', 'Detail Blok: ' . $blok->nama_blok . ' No. ' . $blok->nomor_rumah)
@section('page_heading', 'Detail Data Blok & Rumah')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('admin.blok.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Blok
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-xs">
                    {{ substr($blok->nama_blok, 0, 1) }}
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Blok {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10.5">Berada di lingkungan kawasan {{ $blok->gang->nama_gang }}.</p>
        </div>
        <div class="flex items-center gap-2 pl-10.5 sm:pl-0">
            <a href="{{ route('admin.blok.edit', $blok) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl border border-indigo-100 transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.warga.create') }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Warga di Rumah Ini
            </a>
        </div>
    </div>

    <!-- Info Detail Card & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs lg:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Informasi Rumah & Lokasi</h2>
                </div>
                @if ($blok->status === 'aktif')
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
            </div>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nama Blok</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $blok->nama_blok }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Nomor Rumah</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm font-mono">No. {{ $blok->nomor_rumah }}</dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Gang / Jalan</dt>
                    <dd class="mt-1">
                        <a href="{{ route('admin.gang.show', $blok->gang) }}" class="text-indigo-600 hover:text-indigo-800 font-bold inline-flex items-center gap-1 text-sm">
                            <span>{{ $blok->gang->nama_gang }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </dd>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Status Operasional</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm capitalize">{{ $blok->status }}</dd>
                </div>
                <div class="sm:col-span-2 p-3.5 rounded-xl bg-slate-50/70 border border-slate-100">
                    <dt class="text-slate-400 font-medium">Keterangan</dt>
                    <dd class="text-slate-700 mt-1 leading-relaxed">{{ $blok->keterangan ?: 'Tidak ada keterangan tambahan.' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <div class="w-2 h-2 rounded-full bg-indigo-600"></div>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500">Statistik Rumah</h2>
                </div>
                <div class="space-y-3">
                    <div class="p-4 rounded-xl bg-indigo-50/50 border border-indigo-100/70">
                        <span class="text-xs font-medium text-slate-500 block">Jumlah Penghuni Tercatat</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-black text-indigo-600 font-mono">{{ $blok->wargas->count() }}</span>
                            <span class="text-xs font-medium text-slate-500">Orang</span>
                        </div>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                        <span class="text-xs font-medium text-slate-500 block">Warga Status Tetap</span>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-black text-slate-900 font-mono">{{ $blok->wargas->where('status_warga', 'tetap')->count() }}</span>
                            <span class="text-xs font-medium text-slate-500">Orang</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4 mt-4 border-t border-slate-100">
                <span class="text-[11px] text-slate-400 block">Total penghuni dihitung otomatis dari akun warga aktif yang terafiliasi dengan unit rumah ini.</span>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Warga Penghuni -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/90 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Daftar Penghuni di Blok {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">Seluruh warga keluarga yang tinggal di nomor rumah ini</p>
            </div>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 w-fit">
                {{ $blok->wargas->count() }} warga terdaftar
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Lengkap</th>
                        <th class="px-5 py-3.5">NIK</th>
                        <th class="px-5 py-3.5">Nomor HP</th>
                        <th class="px-5 py-3.5 text-center">Peran Keluarga</th>
                        <th class="px-5 py-3.5 text-center">Status Warga</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($blok->wargas as $index => $warga)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.warga.show', $warga) }}" class="hover:text-indigo-600 transition inline-flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">
                                        {{ substr($warga->nama_lengkap, 0, 1) }}
                                    </span>
                                    <span>{{ $warga->nama_lengkap }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">{{ $warga->nik ?: '-' }}</td>
                            <td class="px-5 py-3.5 font-mono text-slate-600">{{ $warga->nomor_hp ?: '-' }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ ucwords(str_replace('_', ' ', $warga->peran_keluarga)) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $warga->status_warga === 'tetap' ? 'bg-sky-50 text-sky-700 border border-sky-200/70' : 'bg-amber-50 text-amber-700 border border-amber-200/70' }}">
                                    {{ ucfirst($warga->status_warga) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.warga.show', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:text-indigo-600 bg-slate-100/80 hover:bg-slate-200/80 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.warga.edit', $warga) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center">
                                <div class="w-10 h-10 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-2.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-semibold text-slate-600">Belum ada warga yang terdaftar tinggal di rumah ini</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Daftarkan data warga atau ubah hunian warga yang sudah ada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
