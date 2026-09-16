@extends('layouts.dashboard')

@section('title', 'Tambah Warga')
@section('page_heading', 'Tambah Data Warga Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Tambah Warga Baru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan identitas warga dan hunian tempat tinggalnya.</p>
        </div>
        <a href="{{ route('admin.warga.index') }}"
           class="inline-flex items-center px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.warga.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Hunian Blok & Rumah -->
            <div>
                <label for="blok_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Hunian (Blok & Rumah) <span class="text-rose-500">*</span>
                </label>
                <select name="blok_id" id="blok_id" required
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('blok_id') border-rose-300 ring-rose-200 @enderror">
                    <option value="">-- Pilih Blok & Rumah --</option>
                    @foreach ($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                            Blok {{ $blok->nama_blok }} No. {{ $blok->nomor_rumah }} ({{ $blok->gang->nama_gang }})
                        </option>
                    @endforeach
                </select>
                @error('blok_id')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="Nama lengkap warga..."
                       class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nama_lengkap') border-rose-300 ring-rose-200 @enderror">
                @error('nama_lengkap')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK & Nomor HP (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nik" class="block text-xs font-bold text-slate-700 mb-1.5">
                        NIK (KTP 16 digit)
                    </label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" maxlength="16" placeholder="16 digit NIK..."
                           class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nik') border-rose-300 ring-rose-200 @enderror">
                    @error('nik')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nomor_hp" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nomor HP / WhatsApp
                    </label>
                    <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="08xxxxxxxxxx"
                           class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nomor_hp') border-rose-300 ring-rose-200 @enderror">
                    @error('nomor_hp')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
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
                            class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="kepala_keluarga" {{ old('peran_keluarga', 'kepala_keluarga') === 'kepala_keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                        <option value="istri" {{ old('peran_keluarga') === 'istri' ? 'selected' : '' }}>Istri</option>
                        <option value="anak" {{ old('peran_keluarga') === 'anak' ? 'selected' : '' }}>Anak</option>
                        <option value="lainnya" {{ old('peran_keluarga') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('peran_keluarga')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_warga" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Status Kependudukan <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_warga" id="status_warga" required
                            class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="tetap" {{ old('status_warga', 'tetap') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="kontrak" {{ old('status_warga') === 'kontrak' ? 'selected' : '' }}>Kontrak</option>
                        <option value="kost" {{ old('status_warga') === 'kost' ? 'selected' : '' }}>Kost</option>
                    </select>
                    @error('status_warga')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status Keaktifan -->
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" name="is_aktif" id="is_aktif" value="1" {{ old('is_aktif', true) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="is_aktif" class="text-xs font-medium text-slate-700">Warga Aktif Berdomisili</label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.warga.index') }}"
                   class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                    Simpan Data Warga
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
