@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page_heading', 'Profil Saya & Pengaturan Akun')

@section('content')
<div class="space-y-6">

    <!-- Header Banner -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-xl font-bold shadow-md shadow-indigo-500/20 ring-4 ring-indigo-50 shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ $user->name }}</h1>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                        Warga Aktif
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    {{ $user->email }} &bull; Terdaftar sejak {{ $user->created_at ? $user->created_at->translatedFormat('F Y') : '-' }}
                </p>
            </div>
        </div>

        <div class="text-xs text-slate-500 bg-slate-50 px-4 py-2.5 rounded-xl border border-slate-200">
            <span class="font-semibold text-slate-700 block">Unit Tempat Tinggal:</span>
            <span class="text-slate-900 font-medium">
                {{ $warga ? ($warga->blok->nama_blok . ' No. ' . $warga->blok->nomor_rumah . ' (' . $warga->blok->gang->nama_gang . ')') : 'Belum ditautkan' }}
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <h4 class="font-bold text-rose-900 mb-1">Terdapat kesalahan pada isian form:</h4>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Kolom Kiri: Informasi Tempat Tinggal (Read-Only) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Data Hunian & Kependudukan
                    </h2>
                    <span class="text-[10px] px-2 py-0.5 font-bold uppercase rounded bg-slate-100 text-slate-600">Tetap</span>
                </div>

                @if ($warga)
                    <div class="space-y-3.5 text-xs">
                        <div>
                            <span class="text-slate-400 block font-medium">Blok & Nomor Rumah</span>
                            <span class="font-bold text-slate-800 text-sm mt-0.5 block">
                                {{ $warga->blok->nama_blok }} No. {{ $warga->blok->nomor_rumah }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block font-medium">Gang / Wilayah</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">
                                {{ $warga->blok->gang->nama_gang }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block font-medium">NIK (Nomor Induk Kependudukan)</span>
                            <span class="font-mono text-slate-800 font-semibold mt-0.5 block">
                                {{ $warga->nik ? (substr($warga->nik, 0, 6) . '******' . substr($warga->nik, -4)) : '-' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block font-medium">Status Kependudukan</span>
                            <span class="capitalize text-slate-800 font-semibold mt-0.5 block">
                                {{ $warga->status_warga ?? 'Tetap' }}
                            </span>
                        </div>

                        <div>
                            <span class="text-slate-400 block font-medium">Peran dalam Keluarga</span>
                            <span class="capitalize text-slate-800 font-semibold mt-0.5 block">
                                {{ $warga->peran_keluarga ?? 'Kepala Keluarga' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="text-xs text-slate-500 py-3">
                        Akun belum ditautkan ke data master warga.
                    </div>
                @endif

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 text-[11px] text-slate-500 leading-relaxed">
                    <p class="font-semibold text-slate-700 mb-1 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Terproteksi
                    </p>
                    Perubahan data hunian, gang, dan identitas NIK hanya dapat dilakukan oleh Pengurus RT/RW demi keamanan administrasi lingkungan.
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form Edit Data Kontak & Sandi -->
        <div class="lg:col-span-8">
            <form method="POST" action="{{ route('warga.profil.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Data Pribadi & Kontak
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Perbarui nama tampilan, email, dan nomor telepon aktif Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-xs font-semibold text-slate-700 mb-1">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-semibold text-slate-700 mb-1">
                                Alamat Email <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" required
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        </div>

                        <!-- Nomor HP / WA -->
                        <div>
                            <label for="nomor_hp" class="block text-xs font-semibold text-slate-700 mb-1">
                                Nomor Handphone / WhatsApp
                            </label>
                            <input type="text" name="nomor_hp" id="nomor_hp" placeholder="Contoh: 081234567890"
                                   value="{{ old('nomor_hp', $warga?->nomor_hp) }}"
                                   class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Keamanan & Ganti Sandi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/90 shadow-xs space-y-4">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Keamanan Akun (Ganti Kata Sandi)
                        </h2>
                        <p class="text-xs text-slate-500 mt-0.5">Biarkan formulir ini kosong jika Anda tidak ingin mengganti kata sandi.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">
                                Kata Sandi Baru
                            </label>
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                   placeholder="Minimal 6 karakter"
                                   class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">
                                Konfirmasi Kata Sandi Baru
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                   placeholder="Ketik ulang kata sandi baru"
                                   class="w-full text-xs rounded-xl border border-slate-300 py-2.5 px-3.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <div class="flex items-center justify-end gap-3">
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
