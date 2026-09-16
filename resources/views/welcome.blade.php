<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IPL - Iuran Pengelolaan Lingkungan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
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
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white">

    <!-- Navigation Bar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white shadow-sm shadow-indigo-500/25 ring-1 ring-white/20 transition-transform group-hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-base font-bold text-slate-900 tracking-tight block leading-none">IPL</span>
                        <span class="text-[10px] text-slate-400 font-medium block mt-0.5">Iuran Pengelolaan Lingkungan</span>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.dashboard') }}"
                           class="inline-flex items-center gap-1 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition">
                            Dashboard Saya &rarr;
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-1 px-4 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition">
                            Masuk ke Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-12 pb-20 sm:pt-16 sm:pb-24 lg:pt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/80 mb-6">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    Portal Administrasi Lingkungan Mandiri
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-4xl mx-auto leading-tight sm:leading-tight">
                    Pengelolaan Iuran Warga yang <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Transparan & Rapi</span>
                </h1>

                <p class="text-sm sm:text-base text-slate-600 max-w-2xl mx-auto mt-5 leading-relaxed">
                    Sistem pencatatan tagihan dan kas iuran pengelolaan lingkungan (IPL). Warga dapat memantau kewajiban secara mandiri, sementara pengurus RT/RW memiliki laporan pembukuan otomatis siap cetak.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto px-6 py-3 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition flex items-center justify-center gap-2">
                        <span>Masuk ke Portal IPL</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#fitur"
                       class="w-full sm:w-auto px-6 py-3 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl shadow-2xs transition">
                        Pelajari Fitur
                    </a>
                </div>

                <!-- 3 Mini Stats -->
                <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-3xl mx-auto text-left">
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <span class="text-xs text-slate-400 font-medium block">Transparansi</span>
                        <p class="text-base font-bold text-slate-900 mt-1">100% Tercatat Digital</p>
                        <p class="text-xs text-slate-500 mt-0.5">Mencegah selisih pembukuan</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <span class="text-xs text-slate-400 font-medium block">Efisiensi</span>
                        <p class="text-base font-bold text-slate-900 mt-1">Generate Tagihan Otomatis</p>
                        <p class="text-xs text-slate-500 mt-0.5">Sekali klik untuk seluruh warga</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
                        <span class="text-xs text-slate-400 font-medium block">Pelaporan</span>
                        <p class="text-base font-bold text-slate-900 mt-1">Ekspor Excel & PDF</p>
                        <p class="text-xs text-slate-500 mt-0.5">Siap digunakan saat rapat RT/RW</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fitur Section -->
        <section id="fitur" class="py-16 bg-white border-y border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Dirancang untuk Warga & Pengurus</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2">Semua fitur dibangun agar administrasi lingkungan berjalan tertib, transparan, dan dapat diakses dari perangkat apa pun.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Portal Warga Mandiri</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Warga dapat mengecek riwayat tagihan bulanan, status verifikasi pelunasan, mengunduh bukti tanda terima, dan mengelola profil kontak.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Notifikasi Tagihan Otomatis</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Setiap tagihan baru maupun konfirmasi pelunasan langsung diberitahukan ke notifikasi akun warga, dilengkapi pengingat jika ada tunggakan.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Rekap Kas Siap Rapat</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pengurus RT/RW dapat mengunduh rekapitulasi pembayaran dalam format Excel (.xlsx) atau PDF resmi berformat kop surat lengkap tanda tangan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cara Pembayaran Section -->
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-xl mx-auto mb-12">
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">3 Langkah Mudah Pembayaran Iuran</h2>
                    <p class="text-xs text-slate-500 mt-1">Sederhana, cepat, dan terkonfirmasi langsung oleh pengurus lingkungan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs text-center space-y-2">
                        <span class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs inline-flex items-center justify-center">1</span>
                        <h3 class="text-sm font-bold text-slate-900">Cek Tagihan</h3>
                        <p class="text-xs text-slate-500">Buka menu Iuran Saya di portal mandiri untuk melihat nominal tagihan bulan berjalan.</p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs text-center space-y-2">
                        <span class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs inline-flex items-center justify-center">2</span>
                        <h3 class="text-sm font-bold text-slate-900">Lakukan Pembayaran</h3>
                        <p class="text-xs text-slate-500">Transfer ke rekening kas RT atau setorkan secara tunai langsung ke bendahara.</p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs text-center space-y-2">
                        <span class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-xs inline-flex items-center justify-center">3</span>
                        <h3 class="text-sm font-bold text-slate-900">Tercatat Lunas</h3>
                        <p class="text-xs text-slate-500">Status tagihan Anda otomatis terverifikasi dan tercantum pada buku kas resmi lingkungan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-12 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white text-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Mulai Gunakan Sistem IPL Sekarang</h2>
                <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto">Masuk dengan akun yang telah didaftarkan oleh pengurus lingkungan perumahan Anda.</p>
                <div class="pt-2">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 text-xs font-bold text-indigo-950 bg-white hover:bg-slate-100 rounded-xl shadow-md transition">
                        <span>Masuk ke Akun Anda</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        <p>&copy; {{ date('Y') }} Sistem IPL - Iuran Pengelolaan Lingkungan &bull; Transparansi & Akuntabilitas Warga</p>
    </footer>

</body>
</html>
