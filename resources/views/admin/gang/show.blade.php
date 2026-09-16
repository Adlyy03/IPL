@extends('layouts.dashboard')

@section('title', 'Detail Gang: ' . $gang->nama_gang)
@section('page_heading', 'Detail Data Gang')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.gang.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">&larr; Kembali ke Daftar Gang</a>
            </div>
            <h1 class="text-xl font-bold text-slate-900 mt-1">{{ $gang->nama_gang }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Informasi detail gang beserta blok dan rumah di bawah naungannya.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.gang.edit', $gang) }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Data
            </a>
            <a href="{{ route('admin.blok.create') }}"
               class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Blok di Gang Ini
            </a>
        </div>
    </div>

    <!-- Info Detail Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm md:col-span-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Informasi Gang</h2>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <dt class="text-slate-500 font-medium">Nama Gang</dt>
                    <dd class="text-slate-900 font-bold mt-1 text-sm">{{ $gang->nama_gang }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Status Operasional</dt>
                    <dd class="mt-1">
                        @if ($gang->status === 'aktif')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                Nonaktif
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-500 font-medium">Keterangan</dt>
                    <dd class="text-slate-700 mt-1 leading-relaxed">{{ $gang->keterangan ?: 'Tidak ada keterangan tambahan.' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Dibuat Pada</dt>
                    <dd class="text-slate-700 mt-1">{{ $gang->created_at ? $gang->created_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-medium">Terakhir Diperbarui</dt>
                    <dd class="text-slate-700 mt-1">{{ $gang->updated_at ? $gang->updated_at->translatedFormat('d F Y H:i') : '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Statistik Terkait</h2>
            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-500 block">Total Unit Blok / Rumah</span>
                    <span class="text-2xl font-black text-slate-900">{{ $gang->bloks->count() }}</span>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <span class="text-xs text-slate-500 block">Total Warga Penghuni</span>
                    <span class="text-2xl font-black text-indigo-600">{{ $gang->bloks->sum('wargas_count') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Blok di Gang Ini -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Daftar Blok & Rumah di {{ $gang->nama_gang }}</h3>
            <span class="text-xs text-slate-500">{{ $gang->bloks->count() }} unit terdaftar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Blok</th>
                        <th class="px-5 py-3.5">Nomor Rumah</th>
                        <th class="px-5 py-3.5 text-center">Status Blok</th>
                        <th class="px-5 py-3.5 text-center">Jumlah Penghuni</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($gang->bloks as $index => $blok)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400">{{ $index + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">{{ $blok->nama_blok }}</td>
                            <td class="px-5 py-3.5">No. {{ $blok->nomor_rumah }}</td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($blok->status === 'aktif')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $blok->wargas_count }} Orang
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.blok.show', $blok) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.blok.edit', $blok) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400">
                                Belum ada blok atau rumah yang terdaftar di gang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
