@extends('layouts.dashboard')

@section('title', 'Edit Jenis Iuran: ' . $jenisIuran->nama_iuran)
@section('page_heading', 'Edit Master Jenis Iuran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Edit Jenis Iuran</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Perbarui tarif standar atau deskripsi {{ $jenisIuran->nama_iuran }}.</p>
        </div>
        <a href="{{ route('admin.jenis-iuran.index') }}"
           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl transition shadow-2xs">
            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('admin.jenis-iuran.update', $jenisIuran) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Iuran -->
            <div>
                <label for="nama_iuran" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Iuran <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_iuran" id="nama_iuran" value="{{ old('nama_iuran', $jenisIuran->nama_iuran) }}" required
                       class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nama_iuran') border-rose-300 ring-2 ring-rose-100 @enderror">
                @error('nama_iuran')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nominal Standar -->
            <div>
                <label for="nominal" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nominal Tarif Standar (Rp) <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-xs">
                        Rp
                    </div>
                    <input type="number" name="nominal" id="nominal" value="{{ old('nominal', $jenisIuran->nominal) }}" required min="0" step="1000"
                           class="w-full text-xs rounded-xl border border-slate-300 pl-10 pr-3 py-2.5 text-slate-800 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nominal') border-rose-300 ring-2 ring-rose-100 @enderror">
                </div>
                <p class="text-[11px] text-slate-400 mt-1">Tarif dasar default per warga/rumah saat tagihan digenerate secara massal.</p>
                @error('nominal')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Deskripsi / Rincian Penggunaan
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                          class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('deskripsi') border-rose-300 ring-2 ring-rose-100 @enderror">{{ old('deskripsi', $jenisIuran->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-200/80">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_aktif" id="is_aktif" value="1" {{ old('is_aktif', $jenisIuran->is_aktif) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20 focus:ring-offset-0">
                    <div>
                        <span class="text-xs font-semibold text-slate-800 block">Jenis Iuran Aktif Digunakan</span>
                        <span class="text-[11px] text-slate-500">Iuran yang aktif dapat dipilih dalam pembuatan invoice dan generate massal bulanan.</span>
                    </div>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.jenis-iuran.index') }}"
                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all">
                    Perbarui Jenis Iuran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
