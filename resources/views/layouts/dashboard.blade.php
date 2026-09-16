<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - IPL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full flex text-slate-800" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden"
         @click="sidebarOpen = false"></div>

    <!-- Sidebar Komponen -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        
        <!-- Sidebar Brand / Logo -->
        <div class="h-16 flex items-center justify-between px-6 bg-slate-950/40 border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-black text-lg shadow-md shadow-indigo-600/30">
                    IPL
                </div>
                <div>
                    <span class="text-sm font-bold tracking-wide text-white block leading-none">IPL Warga</span>
                    <span class="text-[10px] text-slate-400 font-medium">Pengelolaan Lingkungan</span>
                </div>
            </div>
            <!-- Tombol Tutup Sidebar di Mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto">
            @if (auth()->user()->isAdmin())
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Menu Administrator</div>
                
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <!-- Gang -->
                <a href="{{ route('admin.gang.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.gang.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.gang.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Gang
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.gang.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Master</span>
                </a>

                <!-- Blok & Rumah -->
                <a href="{{ route('admin.blok.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.blok.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.blok.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Blok & Rumah
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.blok.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Master</span>
                </a>

                <!-- Warga -->
                <a href="{{ route('admin.warga.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.warga.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.warga.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Warga
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.warga.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Master</span>
                </a>

                <!-- Jenis Iuran -->
                <a href="{{ route('admin.jenis-iuran.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.jenis-iuran.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.jenis-iuran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Jenis Iuran
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.jenis-iuran.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Master</span>
                </a>

                <!-- Iuran Warga -->
                <a href="{{ route('admin.iuran-warga.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.iuran-warga.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.iuran-warga.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Iuran Warga
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.iuran-warga.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Transaksi</span>
                </a>

                <!-- Laporan -->
                <a href="{{ route('admin.laporan.index') }}"
                   class="flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Laporan
                    </span>
                    <span class="text-[10px] {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-700 text-indigo-100' : 'bg-slate-800 text-slate-400' }} px-1.5 py-0.5 rounded">Rekap</span>
                </a>
            @else
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Portal Warga</div>

                <!-- Dashboard Warga -->
                <a href="{{ route('warga.dashboard') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('warga.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('warga.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <!-- Iuran Saya -->
                <a href="{{ route('warga.iuran.index') }}"
                   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition {{ request()->routeIs('warga.iuran.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('warga.iuran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Iuran Saya
                </a>
            @endif
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 bg-slate-950/40 border-t border-slate-800">
            <div class="flex items-center justify-between">
                <div class="truncate">
                    <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper (Navbar + Content Area) -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-3">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-600 hover:text-slate-900 p-1.5 rounded-lg border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="text-sm font-bold text-slate-800 hidden sm:block">
                    @yield('page_heading', 'Dashboard')
                </div>
            </div>

            <!-- Navbar Right: Role Badge + User Info + Logout -->
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                    <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-500' : 'bg-emerald-500' }}"></span>
                    {{ strtoupper(auth()->user()->role) }}
                </span>

                <span class="text-sm font-medium text-slate-700 hidden md:inline">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            title="Keluar dari akun"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-lg transition duration-150">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- Flash Notification Sukses -->
                @if (session('success'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium leading-relaxed">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Flash Notification Error / Gagal -->
                @if (session('error'))
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-rose-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm font-medium leading-relaxed">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Flash Notification Warning -->
                @if (session('warning'))
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div class="text-sm font-medium leading-relaxed">
                            {{ session('warning') }}
                        </div>
                    </div>
                @endif

                <!-- Error Validasi Global -->
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-bold">Terjadi kesalahan input:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 py-3 px-6 text-center text-xs text-slate-500">
            Sistem IPL (Iuran Pengelolaan Lingkungan) &copy; {{ date('Y') }}
        </footer>
    </div>

</body>
</html>
