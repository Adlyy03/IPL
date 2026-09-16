<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - IPL (Iuran Pengelolaan Lingkungan)</title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                            950: '#1e1b4b',
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif; }
        @media print {
            aside, header, footer, .no-print, .print\:hidden { display: none !important; }
            main { padding: 0 !important; margin: 0 !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="h-full flex text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <!-- Mobile/Tablet Sidebar Backdrop Overlay -->
    <div x-show="sidebarOpen"
         x-cloak
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
         @click="sidebarOpen = false"
         aria-hidden="true"></div>

    <!-- Sidebar Navigation -->
    <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl lg:shadow-none border-r border-slate-800/80"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           aria-label="Navigasi Utama">
        
        <!-- Sidebar Brand / Header -->
        <div class="h-16 flex items-center justify-between px-5 bg-slate-950/50 border-b border-slate-800/90">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white shadow-md shadow-indigo-500/25 ring-1 ring-white/20 transition-transform group-hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-sm font-bold tracking-tight text-white leading-none">IPL Warga</span>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold tracking-wide uppercase rounded bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">v1.0</span>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium block mt-0.5">Pengelolaan Lingkungan</span>
                </div>
            </a>

            <!-- Tombol Tutup Sidebar di Mobile -->
            <button @click="sidebarOpen = false" 
                    type="button"
                    aria-label="Tutup navigasi sidebar"
                    class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-slate-800/80 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation Items -->
        <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto custom-scrollbar">
            @if (auth()->user()->isAdmin())
                <!-- Menu Ringkasan -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Ringkasan</div>
                    <div class="space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Master Data -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Master Data</div>
                    <div class="space-y-1">
                        <!-- Gang -->
                        <a href="{{ route('admin.gang.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.gang.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.gang.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                <span>Data Gang</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.gang.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Master</span>
                        </a>

                        <!-- Blok & Rumah -->
                        <a href="{{ route('admin.blok.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.blok.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.blok.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Blok & Rumah</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.blok.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Master</span>
                        </a>

                        <!-- Warga -->
                        <a href="{{ route('admin.warga.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.warga.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.warga.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>Data Warga</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.warga.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Master</span>
                        </a>

                        <!-- Jenis Iuran -->
                        <a href="{{ route('admin.jenis-iuran.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.jenis-iuran.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.jenis-iuran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>Jenis Iuran</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.jenis-iuran.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Master</span>
                        </a>
                    </div>
                </div>

                <!-- Transaksi & Laporan -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Keuangan & Pembukuan</div>
                    <div class="space-y-1">
                        <!-- Iuran Warga -->
                        <a href="{{ route('admin.iuran-warga.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.iuran-warga.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.iuran-warga.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Iuran Warga</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.iuran-warga.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Transaksi</span>
                        </a>

                        <!-- Laporan -->
                        <a href="{{ route('admin.laporan.index') }}"
                           class="flex items-center justify-between px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-3 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Laporan Keuangan</span>
                            </span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-md font-medium {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-700/60 text-white' : 'bg-slate-800 text-slate-400' }}">Rekap</span>
                        </a>
                    </div>
                </div>
            @else
                <!-- Portal Warga -->
                <div>
                    <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Portal Warga</div>
                    <div class="space-y-1">
                        <a href="{{ route('warga.dashboard') }}"
                           class="flex items-center px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('warga.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-3 {{ request()->routeIs('warga.dashboard') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('warga.iuran.index') }}"
                           class="flex items-center px-3 py-2.5 text-xs font-semibold rounded-xl transition duration-150 {{ request()->routeIs('warga.iuran.*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-3 {{ request()->routeIs('warga.iuran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Iuran Saya</span>
                        </a>
                    </div>
                </div>
            @endif
        </nav>

        <!-- Sidebar User Footer -->
        <div class="p-4 bg-slate-950/60 border-t border-slate-800/90">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-xs font-bold text-indigo-300 shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-white truncate leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                            title="Keluar dari akun"
                            aria-label="Logout"
                            class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition duration-150">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Navbar -->
        <header class="h-16 bg-white/95 backdrop-blur-md border-b border-slate-200/90 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <!-- Hamburger Menu Button (Mobile & Tablet) -->
                <button @click="sidebarOpen = true"
                        type="button"
                        aria-label="Buka navigasi sidebar"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Page Context / Breadcrumb -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-slate-400 hidden sm:inline">IPL Admin</span>
                    <span class="text-xs text-slate-300 hidden sm:inline">/</span>
                    <h1 class="text-sm sm:text-base font-bold text-slate-900 truncate">
                        @yield('page_heading', 'Dashboard')
                    </h1>
                </div>
            </div>

            <!-- Topbar Right: Role Pill + User Info + Logout -->
            <div class="flex items-center gap-3 sm:gap-4">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-indigo-50 text-indigo-700 border border-indigo-200/70' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ auth()->user()->isAdmin() ? 'bg-indigo-600' : 'bg-emerald-500' }}"></span>
                    {{ strtoupper(auth()->user()->role) }}
                </span>

                <div class="hidden sm:flex items-center gap-2 text-xs font-medium text-slate-700 pl-2 border-l border-slate-200">
                    <span>{{ auth()->user()->name }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                            title="Keluar dari akun"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100/80 border border-rose-200/80 rounded-xl transition duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Area Content Wrapper -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-slate-50/60">
            <div class="max-w-7xl mx-auto space-y-6">

                <!-- Flash Notification: Sukses -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="p-4 rounded-2xl bg-emerald-50/90 border border-emerald-200 text-emerald-900 flex items-start justify-between gap-3 shadow-xs">
                        <div class="flex items-start gap-3">
                            <div class="p-1 rounded-lg bg-emerald-100 text-emerald-600 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Berhasil</h4>
                                <p class="text-xs font-medium text-emerald-800 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" type="button" aria-label="Tutup notifikasi" class="text-emerald-500 hover:text-emerald-800 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Flash Notification: Error -->
                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="p-4 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-900 flex items-start justify-between gap-3 shadow-xs">
                        <div class="flex items-start gap-3">
                            <div class="p-1 rounded-lg bg-rose-100 text-rose-600 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-rose-950">Peringatan</h4>
                                <p class="text-xs font-medium text-rose-800 mt-0.5 leading-relaxed">{{ session('error') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" type="button" aria-label="Tutup notifikasi" class="text-rose-500 hover:text-rose-800 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Flash Notification: Warning -->
                @if (session('warning'))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="p-4 rounded-2xl bg-amber-50/90 border border-amber-200 text-amber-900 flex items-start justify-between gap-3 shadow-xs">
                        <div class="flex items-start gap-3">
                            <div class="p-1 rounded-lg bg-amber-100 text-amber-600 shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-amber-950">Perhatian</h4>
                                <p class="text-xs font-medium text-amber-800 mt-0.5 leading-relaxed">{{ session('warning') }}</p>
                            </div>
                        </div>
                        <button @click="show = false" type="button" aria-label="Tutup notifikasi" class="text-amber-500 hover:text-amber-800 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Error Validasi Global -->
                @if ($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50/90 border border-rose-200 text-rose-900 shadow-xs">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="p-1 rounded-lg bg-rose-100 text-rose-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-rose-950">Periksa kembali formulir Anda:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-800 ml-7">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Yield Content -->
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200/90 py-3.5 px-6 text-center text-xs text-slate-500 font-medium">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>Sistem IPL (Iuran Pengelolaan Lingkungan) &copy; {{ date('Y') }}</span>
                <span class="text-slate-400 text-[11px]">Aplikasi Manajemen Lingkungan Mandiri</span>
            </div>
        </footer>
    </div>

</body>
</html>
