@extends('layouts.dashboard')

@section('title', 'Edit Gang: ' . $gang->nama_gang)
@section('page_heading', 'Edit Master Data Gang')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Data Gang</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui informasi gang <span class="font-semibold text-slate-800">{{ $gang->nama_gang }}</span>.</p>
        </div>
        <a href="{{ route('admin.gang.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-xs transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-8 rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('admin.gang.update', $gang) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Gang -->
            <div>
                <label for="nama_gang" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Gang / Jalan <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_gang" id="nama_gang" value="{{ old('nama_gang', $gang->nama_gang) }}" required
                       class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition @error('nama_gang') border-rose-300 ring-2 ring-rose-200 @enderror">
                @error('nama_gang')
                    <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Keterangan Lokasi
                </label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition @error('keterangan') border-rose-300 ring-2 ring-rose-200 @enderror">{{ old('keterangan', $gang->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Status Operasional <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full text-xs sm:text-sm rounded-xl border-slate-200 py-2.5 px-3.5 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
                    <option value="aktif" {{ old('status', $gang->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $gang->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-rose-600 text-xs mt-1.5 flex items-center gap-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                <a href="{{ route('admin.gang.index') }}"
                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Perbarui Data Gang</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
