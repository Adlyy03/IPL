@extends('layouts.app')

@section('title', 'Masuk Akun')

@section('content')
<div class="max-w-md mx-auto my-6 sm:my-10" x-data="{ showPassword: false }">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/90 p-6 sm:p-8 space-y-6">
        
        <!-- Header & Logo -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white mx-auto shadow-md shadow-indigo-500/25 ring-4 ring-indigo-50">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Masuk ke Sistem IPL</h1>
            <p class="text-xs text-slate-500">Silakan masukkan email dan kata sandi akun Anda</p>
        </div>

        @if ($errors->any())
            <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl">
                <div class="flex items-center gap-2 font-bold mb-1">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Gagal Masuk</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 pl-9 pr-3 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition"
                           placeholder="nama@email.com">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'"
                           name="password" id="password" required
                           class="w-full text-xs rounded-xl border border-slate-300 py-2.5 pl-9 pr-10 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition"
                           placeholder="••••••••">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 focus:outline-none"
                            title="Tampilkan / Sembunyikan Sandi">
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition duration-150 flex items-center justify-center gap-2">
                <span>Masuk ke Akun</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Informasi Akun Uji Coba -->
        <div class="pt-5 border-t border-slate-100">
            <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Akun Uji Coba (Demo):</h2>
            <div class="space-y-2 text-xs">
                <button type="button"
                        onclick="document.getElementById('email').value='admin@ipl.test'; document.getElementById('password').value='password';"
                        class="w-full text-left p-2.5 rounded-xl bg-slate-50 hover:bg-indigo-50/50 border border-slate-200/80 transition flex items-center justify-between group">
                    <div>
                        <span class="font-bold text-indigo-700 block">Administrator:</span>
                        <span class="text-slate-500 font-mono text-[11px]">admin@ipl.test / password</span>
                    </div>
                    <span class="text-[10px] text-indigo-600 opacity-0 group-hover:opacity-100 transition font-medium">Klik untuk isi &rarr;</span>
                </button>

                <button type="button"
                        onclick="document.getElementById('email').value='warga@ipl.test'; document.getElementById('password').value='password';"
                        class="w-full text-left p-2.5 rounded-xl bg-slate-50 hover:bg-emerald-50/50 border border-slate-200/80 transition flex items-center justify-between group">
                    <div>
                        <span class="font-bold text-emerald-700 block">Warga:</span>
                        <span class="text-slate-500 font-mono text-[11px]">warga@ipl.test / password</span>
                    </div>
                    <span class="text-[10px] text-emerald-600 opacity-0 group-hover:opacity-100 transition font-medium">Klik untuk isi &rarr;</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
