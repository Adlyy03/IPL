@extends('layouts.app')

@section('title', 'Masuk Akun')

@section('content')
<div class="max-w-md mx-auto my-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Masuk ke Sistem IPL</h1>
            <p class="text-sm text-gray-500 mt-1">Silakan masukkan email dan kata sandi Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                       placeholder="nama@email.com">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-3.5 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                       placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                    Ingat saya
                </label>
            </div>

            <button type="submit"
                    class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition duration-150">
                Masuk
            </button>
        </form>

        <!-- Informasi Akun Dummy untuk Pengujian -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Akun Uji Coba (Seeder):</h2>
            <div class="space-y-2 text-xs bg-gray-50 p-3 rounded-lg border border-gray-200">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-purple-700">Admin:</span>
                    <span class="text-gray-600">admin@ipl.test / password</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-medium text-emerald-700">Warga:</span>
                    <span class="text-gray-600">warga@ipl.test / password</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
