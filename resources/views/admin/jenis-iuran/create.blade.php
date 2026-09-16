@extends('layouts.dashboard')

@section('title', 'Tambah Jenis Iuran')
@section('page_heading', 'Tambah Master Jenis Iuran')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Jenis Iuran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Definisikan kategori retribusi atau iuran baru.</p>
        </div>
        <a href="{{ route('admin.jenis-iuran.index') }}"
           class="inline-flex items-center px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.jenis-iuran.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Iuran -->
            <div>
                <label for="nama_iuran" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Iuran <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_iuran" id="nama_iuran" value="{{ old('nama_iuran') }}" required placeholder="Contoh: Iuran Kebersihan Lingkungan"
                       class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_iuran') border-rose-300 ring-rose-200 @enderror">
                @error('nama_iuran')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nominal Standar -->
            <div>
                <label for="nominal" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nominal Tarif Standar (Rp) <span class="text-rose-500">*</span>
                </label>
                <input type="number" name="nominal" id="nominal" value="{{ old('nominal', 50000) }}" required min="0" step="1000"
                       class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nominal') border-rose-300 ring-rose-200 @enderror">
                @error('nominal')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Deskripsi / Rincian Penggunaan
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3" placeholder="Jelaskan peruntukan iuran ini..."
                          class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-rose-300 ring-rose-200 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" name="is_aktif" id="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_aktif" class="text-xs font-medium text-slate-700">Jenis Iuran Aktif Digunakan</label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.jenis-iuran.index') }}"
                   class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                    Simpan Jenis Iuran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
