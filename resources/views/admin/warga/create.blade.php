@extends('layouts.dashboard')

@section('title', 'Tambah Warga')
@section('page_heading', 'Tambah Data Warga Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Tambah Warga Baru</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Daftarkan identitas warga, status kependudukan, dan nomor hunian.</p>
        </div>
        <a href="{{ route('admin.warga.index') }}"
           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl transition shadow-2xs">
            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('admin.warga.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Hunian Blok & Rumah -->
            <div>
                <label for="blok_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Hunian (Blok & Rumah) <span class="text-rose-500">*</span>
                </label>
                <select name="blok_id" id="blok_id" required
                        class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('blok_id') border-rose-300 ring-2 ring-rose-100 @enderror">
                    <option value="">-- Pilih Blok & Rumah --</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                            Blok {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }} ({{ $blok->gang->nama_gang }})
                        </option>
                    @endforeach
                </select>
                @error('blok_id')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap warga sesuai KTP..."
                       class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nama_lengkap') border-rose-300 ring-2 ring-rose-100 @enderror">
                @error('nama_lengkap')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- NIK & Nomor HP (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nik" class="block text-xs font-bold text-slate-700 mb-1.5">
                        NIK (KTP 16 digit)
                    </label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" placeholder="Contoh: 3201xxxxxxxxxxxx"
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 font-mono placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nik') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @error('nik')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_hp" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nomor HP / WhatsApp
                    </label>
                    <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="Contoh: 081234567890"
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 font-mono placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nomor_hp') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @error('nomor_hp')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Peran Keluarga & Status Warga (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="peran_keluarga" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Peran dalam Keluarga <span class="text-rose-500">*</span>
                    </label>
                    <select name="peran_keluarga" id="peran_keluarga" required
                            class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        <option value="kepala_keluarga" {{ old('peran_keluarga', 'kepala_keluarga') === 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="istri" {{ old('peran_keluarga') === 'istri' ? 'selected' : '' }}>Istri</option>
                        <option value="anak" {{ old('peran_keluarga') === 'anak' ? 'selected' : '' }}>Anak</option>
                        <option value="lainnya" {{ old('peran_keluarga') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('peran_keluarga')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="status_warga" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Status Kependudukan <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_warga" id="status_warga" required
                            class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        <option value="tetap" {{ old('status_warga', 'tetap') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="kontrak" {{ old('status_warga') === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="kost" {{ old('status_warga') === 'kost' ? 'selected' : '' }}>Kost</option>
                    </select>
                    @error('status_warga')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Status Keaktifan -->
            <div class="p-3.5 rounded-xl bg-slate-50/80 border border-slate-200/80">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_aktif" id="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/20 focus:ring-offset-0">
                    <div>
                        <span class="text-xs font-semibold text-slate-800 block">Warga Aktif Berdomisili</span>
                        <span class="text-[11px] text-slate-500">Centang jika warga saat ini aktif menempati hunian dan menjadi subjek iuran lingkungan.</span>
                    </div>
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.warga.index') }}"
                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all">
                    Simpan Data Warga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
