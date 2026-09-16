@extends('layouts.dashboard')

@section('title', 'Tambah Gang')
@section('page_heading', 'Tambah Master Data Gang')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Gang Baru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi formulir berikut untuk menambahkan gang baru.</p>
        </div>
        <a href="{{ route('admin.gang.index') }}"
           class="inline-flex items-center px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.gang.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Gang -->
            <div>
                <label for="nama_gang" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Gang <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_gang" id="nama_gang" value="{{ old('nama_gang') }}" required placeholder="Contoh: Gang Kenanga"
                       class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_gang') border-rose-300 ring-rose-200 @enderror">
                @error('nama_gang')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Keterangan
                </label>
                <textarea name="keterangan" id="keterangan" rows="3" placeholder="Keterangan tambahan lokasi gang..."
                          class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('keterangan') border-rose-300 ring-rose-200 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Status Gang <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.gang.index') }}"
                   class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                    Simpan Gang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
