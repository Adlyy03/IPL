@extends('layouts.dashboard')

@section('title', 'Rincian Tagihan #IPL-' . str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT))
@section('page_heading', 'Rincian Tagihan Iuran')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between gap-3 print:hidden">
        <a href="{{ route('warga.iuran.index') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-2xs transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Riwayat
        </a>

        <button onclick="window.print()"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200/90 rounded-xl shadow-2xs transition">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Bukti Tagihan
        </button>
    </div>

    <!-- Invoice Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">

        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between pb-6 border-b border-slate-200 gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-lg text-xs font-bold bg-indigo-600 text-white">IPL</span>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Bukti Tagihan Lingkungan</span>
                </div>
                <h1 class="text-2xl font-bold font-mono text-slate-900">#IPL-{{ str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <p class="text-xs text-slate-500 mt-1">Periode Tagihan: <span class="font-mono font-bold text-slate-800">{{ $iuranWarga->periode }}</span></p>
            </div>

            <div class="sm:text-right">
                <span class="text-xs text-slate-400 block mb-1.5">Status Pembayaran:</span>
                @if ($iuranWarga->status_pembayaran === 'lunas')
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        LUNAS
                    </span>
                @elseif ($iuranWarga->status_pembayaran === 'batal')
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                        BATAL
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        MENUNGGU PEMBAYARAN
                    </span>
                @endif
            </div>
        </div>

        <!-- Resident & Property Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pb-6 border-b border-slate-100 text-xs">
            <div class="space-y-2">
                <h3 class="font-bold text-slate-400 uppercase tracking-wider text-[11px]">Diterbitkan Untuk</h3>
                <p class="text-base font-bold text-slate-900">{{ $iuranWarga->warga?->nama_lengkap ?? '-' }}</p>
                <p class="text-slate-600">NIK: <span class="font-mono font-medium">{{ $iuranWarga->warga?->nik ?? '-' }}</span></p>
                <p class="text-slate-600">Status Warga: <span class="capitalize">{{ $iuranWarga->warga?->status_warga ?? 'Warga Tetap' }}</span></p>
            </div>

            <div class="space-y-2 sm:text-right">
                <h3 class="font-bold text-slate-400 uppercase tracking-wider text-[11px]">Unit Hunian</h3>
                <p class="text-base font-bold text-slate-900">
                    {{ $iuranWarga->warga?->blok ? ($iuranWarga->warga->blok->nama_blok . ' No. ' . $iuranWarga->warga->blok->nomor_rumah) : '-' }}
                </p>
                <p class="text-slate-600">Gang / Wilayah: <span class="font-semibold">{{ $iuranWarga->warga?->blok?->gang?->nama_gang ?? '-' }}</span></p>
                <p class="text-slate-500">Tanggal Terbit: {{ $iuranWarga->created_at ? $iuranWarga->created_at->translatedFormat('d F Y') : '-' }}</p>
            </div>
        </div>

        <!-- Table of Charges -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Deskripsi Item Iuran</th>
                        <th class="py-3 px-4 text-center">Periode</th>
                        <th class="py-3 px-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="py-4 px-4 font-semibold text-slate-900 text-sm">
                            {{ $iuranWarga->jenisIuran?->nama_iuran ?? 'Iuran Pengelolaan Lingkungan' }}
                            @if ($iuranWarga->catatan)
                                <p class="text-xs text-slate-500 font-normal mt-0.5">{{ $iuranWarga->catatan }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center font-mono text-slate-700">
                            {{ $iuranWarga->periode }}
                        </td>
                        <td class="py-4 px-4 text-right font-bold text-slate-900 text-sm">
                            Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="border-t-2 border-slate-200 bg-slate-50/70 font-bold">
                    <tr>
                        <td colspan="2" class="py-3.5 px-4 text-slate-700 text-right uppercase tracking-wider">Total Tagihan:</td>
                        <td class="py-3.5 px-4 text-right text-indigo-700 text-base">
                            Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Payment Status Details / Instructions -->
        @if ($iuranWarga->status_pembayaran === 'lunas')
            <div class="p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 text-xs text-emerald-900 space-y-1">
                <div class="flex items-center gap-2 font-bold text-emerald-950">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                    Pembayaran Berhasil Diverifikasi
                </div>
                <p class="text-emerald-800">
                    Tanggal Lunas: <span class="font-semibold">{{ $iuranWarga->tanggal_pembayaran ? $iuranWarga->tanggal_pembayaran->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                </p>
                @if ($iuranWarga->catatan)
                    <p class="text-emerald-700 mt-1 italic">Catatan: {{ $iuranWarga->catatan }}</p>
                @endif
            </div>
        @else
            <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200 text-xs text-amber-900 space-y-3">
                <div class="flex items-center gap-2 font-bold text-amber-950">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Panduan & Instruksi Pembayaran
                </div>
                <p class="text-amber-800 leading-relaxed">
                    Silakan lakukan pembayaran iuran sesuai nominal tepat <strong>Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}</strong> melalui salah satu metode berikut:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="bg-white p-3 rounded-xl border border-amber-200">
                        <span class="font-bold text-slate-800 block">1. Pembayaran Tunai</span>
                        <p class="text-slate-600 mt-1">Dapat diserahkan langsung ke bendahara RT/RW lingkungan.</p>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-amber-200">
                        <span class="font-bold text-slate-800 block">2. Transfer Rekening Kas Lingkungan</span>
                        <p class="text-slate-600 mt-1 font-mono">Bank BCA: <strong>123-456-7890</strong><br>a.n. Kas Pengelola Lingkungan</p>
                    </div>
                </div>
                <p class="text-[11px] text-amber-700 italic">
                    Setelah pembayaran selesai, pengurus admin akan mencatat verifikasi dan status tagihan Anda otomatis berganti menjadi Lunas.
                </p>
            </div>
        @endif

    </div>
</div>
@endsection
