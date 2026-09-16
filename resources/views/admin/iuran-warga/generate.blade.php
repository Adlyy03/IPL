@extends('layouts.dashboard')

@section('title', 'Generate Tagihan Massal')
@section('page_heading', 'Generate Tagihan Iuran Massal')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Generate Tagihan Massal</h1>
            <p class="text-xs text-slate-500 mt-0.5">Terbitkan tagihan iuran secara serentak untuk warga aktif berdasarkan cakupan.</p>
        </div>
        <a href="{{ route('admin.iuran-warga.index') }}"
           class="inline-flex items-center px-3 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <!-- Informasi / Catatan Sistem -->
    <div class="p-4 rounded-2xl bg-indigo-50/70 border border-indigo-100 text-indigo-900 space-y-2">
        <div class="flex items-center gap-2 font-bold text-xs text-indigo-950">
            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ketentuan & Mekanisme Generate Tagihan
        </div>
        <ul class="list-disc list-inside text-xs text-indigo-800/90 space-y-1">
            <li>Tagihan hanya akan diterbitkan untuk warga dengan status <strong>Aktif</strong>.</li>
            <li><strong>Pencegahan Duplikasi:</strong> Jika warga sudah memiliki tagihan untuk jenis dan periode yang sama, sistem otomatis melewati dan tidak membuat duplikat.</li>
            <li>Database Transaction memastikan seluruh tagihan tersimpan utuh dan konsisten.</li>
        </ul>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm" x-data="{ cakupan: '{{ old('cakupan', 'semua') }}' }">
        <form action="{{ route('admin.iuran-warga.generate.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Pilih Jenis Iuran -->
            <div>
                <label for="jenis_iuran_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Jenis Iuran <span class="text-rose-500">*</span>
                </label>
                <select name="jenis_iuran_id" id="jenis_iuran_id" required
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('jenis_iuran_id') border-rose-300 ring-rose-200 @enderror">
                    <option value="">-- Pilih Jenis Iuran --</option>
                    @foreach ($jenisIurans as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_iuran_id', request('jenis_iuran_id')) == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_iuran }} (Tarif Standar: Rp {{ number_format($jenis->nominal, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('jenis_iuran_id')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Periode & Nominal Tagihan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="periode" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Periode Tagihan (YYYY-MM) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="periode" id="periode" value="{{ old('periode', date('Y-m')) }}" required placeholder="YYYY-MM (Contoh: {{ date('Y-m') }})"
                           class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('periode') border-rose-300 ring-rose-200 @enderror">
                    @error('periode')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nominal" class="block text-xs font-bold text-slate-700 mb-1.5">
                        Nominal Tagihan (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="nominal" id="nominal" value="{{ old('nominal', 50000) }}" required min="0" step="1000"
                           class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500 @error('nominal') border-rose-300 ring-rose-200 @enderror">
                    @error('nominal')
                        <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Cakupan Warga -->
            <div>
                <label for="cakupan" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Cakupan Target Warga <span class="text-rose-500">*</span>
                </label>
                <select name="cakupan" id="cakupan" required x-model="cakupan"
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="semua">Semua Wilayah (Seluruh Warga Aktif)</option>
                    <option value="gang">Berdasarkan Gang Tertentu</option>
                    <option value="blok">Berdasarkan Blok Tertentu</option>
                </select>
                @error('cakupan')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilihan Gang (jika cakupan gang) -->
            <div x-show="cakupan === 'gang'" style="display: none;">
                <label for="gang_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Pilih Gang Target <span class="text-rose-500">*</span>
                </label>
                <select name="gang_id" id="gang_id"
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Gang --</option>
                    @foreach ($gangs as $gang)
                        <option value="{{ $gang->id }}" {{ old('gang_id') == $gang->id ? 'selected' : '' }}>
                            {{ $gang->nama_gang }}
                        </option>
                    @endforeach
                </select>
                @error('gang_id')
                    <p class="text-rose-600 text-[11px] mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilihan Blok (jika cakupan blok) -->
            <div x-show="cakupan === 'blok'" style="display: none;">
                <label for="blok_id" class="block text-xs font-bold text-slate-700 mb-1.5">
                    Pilih Blok Target <span class="text-rose-500">*</span>
                </label>
                <select name="blok_id" id="blok_id"
                        class="w-full text-xs rounded-xl border-slate-300 py-2.5 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Pilih Blok --</option>
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

            <!-- Hanya Kepala Keluarga -->
            <div class="flex items-center space-x-2 pt-2">
                <input type="checkbox" name="hanya_kepala_keluarga" id="hanya_kepala_keluarga" value="1" {{ old('hanya_kepala_keluarga', true) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <label for="hanya_kepala_keluarga" class="text-xs font-medium text-slate-700">
                    Hanya Terbitkan untuk <strong>Kepala Keluarga</strong> (1 tagihan per kartu keluarga/rumah)
                </label>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.iuran-warga.index') }}"
                   class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-800 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Batal
                </a>
                <button type="submit"
                        onclick="return confirm('Apakah Anda yakin ingin memproses generate tagihan massal ini?');"
                        class="px-5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
                    Proses Generate Tagihan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
