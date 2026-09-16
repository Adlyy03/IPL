@extends('layouts.dashboard')

@section('title', 'Tambah Blok & Rumah')
@section('page_heading', 'Tambah Master Blok & Rumah')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Blok Baru</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Daftarkan blok dan nomor rumah pada lingkungan perumahan warga.</p>
        </div>
        <a href="{{ route('admin.blok.index') }}"
           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl transition shadow-2xs">
            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('admin.blok.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Pilih Gang -->
            <div>
                <label for="gang_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Pilih Gang <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <select name="gang_id" id="gang_id" required
                            class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('gang_id') border-rose-300 ring-2 ring-rose-100 @enderror">
                        <option value="">-- Pilih Gang --</option>
                        @foreach ($gangs as $gang)
                            <option value="{{ $gang->id }}" {{ old('gang_id') == $gang->id ? 'selected' : '' }}>
                                {{ $gang->nama_gang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('gang_id')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Grid: Nama Blok & Nomor Rumah -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Blok -->
                <div>
                    <label for="nama_blok" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nama Blok <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_blok" id="nama_blok" value="{{ old('nama_blok') }}" required placeholder="Contoh: Blok A1"
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nama_blok') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @error('nama_blok')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nomor Rumah -->
                <div>
                    <label for="nomor_rumah" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nomor Rumah <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nomor_rumah" id="nomor_rumah" value="{{ old('nomor_rumah') }}" required placeholder="Contoh: 12 / 12A"
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nomor_rumah') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @error('nomor_rumah')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Keterangan
                </label>
                <textarea name="keterangan" id="keterangan" rows="2" placeholder="Catatan opsional mengenai blok atau rumah ini..."
                          class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('keterangan') border-rose-300 ring-2 ring-rose-100 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Status Blok <span class="text-rose-500">*</span>
                </label>
                <select name="status" id="status" required
                        class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="aktif" {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('status')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.blok.index') }}"
                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all">
                    Simpan Blok
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
