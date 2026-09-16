@extends('layouts.dashboard')

@section('title', 'Edit Tagihan Iuran')
@section('page_heading', 'Edit Data Tagihan Iuran')

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
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Edit Data Tagihan</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Perbarui rincian tagihan atau konfirmasi status pembayaran warga.</p>
        </div>
        <a href="{{ route('admin.iuran-warga.index') }}"
           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl transition shadow-2xs">
            <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200/90 shadow-xs">
        <form action="{{ route('admin.iuran-warga.update', $iuranWarga) }}" method="POST" class="space-y-5" x-data="{ status: '{{ old('status_pembayaran', $iuranWarga->status_pembayaran) }}' }">
            @csrf
            @method('PUT')

            <!-- Pilih Warga -->
            <div>
                <label for="warga_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Warga Terkait <span class="text-rose-500">*</span>
                </label>
                <select name="warga_id" id="warga_id" required
                        class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('warga_id') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @foreach ($wargas as $warga)
                        <option value="{{ $warga->id }}" {{ old('warga_id', $iuranWarga->warga_id) == $warga->id ? 'selected' : '' }}>
                            {{ $warga->nama_lengkap }} — Blok {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }} ({{ $warga->blok->gang->nama_gang }})
                        </option>
                    @endforeach
                </select>
                @error('warga_id')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Pilih Jenis Iuran -->
            <div>
                <label for="jenis_iuran_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Jenis Iuran <span class="text-rose-500">*</span>
                </label>
                <select name="jenis_iuran_id" id="jenis_iuran_id" required
                        class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('jenis_iuran_id') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @foreach ($jenisIurans as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_iuran_id', $iuranWarga->jenis_iuran_id) == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_iuran }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_iuran_id')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Periode & Nominal Tagihan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="periode" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Periode Tagihan (YYYY-MM) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="periode" id="periode" value="{{ old('periode', $iuranWarga->periode) }}" required
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 font-mono text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('periode') border-rose-300 ring-2 ring-rose-100 @enderror">
                    @error('periode')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="nominal" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nominal Tagihan (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-xs">
                            Rp
                        </div>
                        <input type="number" name="nominal" id="nominal" value="{{ old('nominal', $iuranWarga->nominal) }}" required min="0" step="1000"
                               class="w-full text-xs rounded-xl border border-slate-300 pl-10 pr-3 py-2.5 font-mono font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition @error('nominal') border-rose-300 ring-2 ring-rose-100 @enderror">
                    </div>
                    @error('nominal')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Status Pembayaran -->
            <div>
                <label for="status_pembayaran" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Status Pembayaran <span class="text-rose-500">*</span>
                </label>
                <select name="status_pembayaran" id="status_pembayaran" required x-model="status"
                        class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                    <option value="lunas">Lunas</option>
                    <option value="batal">Batal</option>
                </select>
                @error('status_pembayaran')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Kolom Tambahan Jika Lunas -->
            <div x-show="status === 'lunas'" class="space-y-4 pt-4 border-t border-slate-100" style="display: none;">
                <div>
                    <label for="tanggal_pembayaran" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Tanggal & Waktu Pembayaran
                    </label>
                    <input type="datetime-local" name="tanggal_pembayaran" id="tanggal_pembayaran"
                           value="{{ old('tanggal_pembayaran', $iuranWarga->tanggal_pembayaran ? $iuranWarga->tanggal_pembayaran->format('Y-m-d\TH:i') : date('Y-m-d\TH:i')) }}"
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                    @error('tanggal_pembayaran')
                        <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Catatan -->
            <div>
                <label for="catatan" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Catatan Transaksi
                </label>
                <textarea name="catatan" id="catatan" rows="2" placeholder="Catatan opsional kwitansi / metode pembayaran..."
                          class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">{{ old('catatan', $iuranWarga->catatan) }}</textarea>
                @error('catatan')
                    <p class="text-rose-600 text-[11px] mt-1.5 flex items-center gap-1 font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.iuran-warga.index') }}"
                   class="px-4 py-2.5 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200/80 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all">
                    Perbarui Tagihan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
