@extends('layouts.dashboard')

@section('title', 'Detail Tagihan Iuran #' . $iuranWarga->id)
@section('page_heading', 'Detail Transaksi Iuran Warga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <a href="{{ route('admin.iuran-warga.index') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Tagihan
                </a>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 font-bold text-xs">
                    #
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Invoice Tagihan #IPL-{{ str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT) }}</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10.5">Diterbitkan untuk {{ $iuranWarga->warga->nama_lengkap }} periode {{ $iuranWarga->periode }}.</p>
        </div>
        <div class="flex items-center gap-2 pl-10.5 sm:pl-0">
            <a href="{{ route('admin.iuran-warga.edit', $iuranWarga) }}"
               class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl border border-indigo-100 transition">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <button onclick="window.print()"
                    class="inline-flex items-center px-3.5 py-2.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200/90 hover:bg-slate-50 rounded-xl shadow-2xs transition">
                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Bukti
            </button>
        </div>
    </div>

    <!-- Lembar Tagihan / Invoice Card -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs p-6 sm:p-8 space-y-6">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="inline-flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-black text-sm shadow-sm shadow-indigo-600/30">
                        IPL
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 text-sm block">Sistem Iuran Pengelolaan Lingkungan</span>
                        <p class="text-[11px] text-slate-400">Aplikasi Administrasi & Finansial Warga Lingkungan</p>
                    </div>
                </div>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Status Tagihan</span>
                @if ($iuranWarga->status_pembayaran === 'lunas')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/80 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        &bull; LUNAS
                    </span>
                @elseif ($iuranWarga->status_pembayaran === 'batal')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200/80 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                        &bull; BATAL
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/80 mt-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        &bull; MENUNGGU PEMBAYARAN
                    </span>
                @endif
            </div>
        </div>

        <!-- Detail Warga & Periode -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100">
                <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px]">Ditagihkan Kepada:</span>
                <p class="font-bold text-slate-900 text-sm mt-1">{{ $iuranWarga->warga->nama_lengkap }}</p>
                <p class="text-slate-700 font-medium mt-1">Blok {{ $iuranWarga->warga->blok->nama_blok }} No. {{ $iuranWarga->warga->blok->nomor_rumah }}</p>
                <p class="text-slate-500">{{ $iuranWarga->warga->blok->gang->nama_gang }}</p>
                <p class="text-slate-500 font-mono mt-2">No. HP: {{ $iuranWarga->warga->nomor_hp ?: '-' }}</p>
            </div>
            <div class="p-4 rounded-xl bg-slate-50/70 border border-slate-100 sm:text-right">
                <span class="text-slate-400 font-bold uppercase tracking-wider block text-[10px]">Rincian Transaksi:</span>
                <p class="text-slate-700 mt-1"><span class="text-slate-400">No. Tagihan:</span> <span class="font-mono font-bold text-slate-900">#IPL-{{ str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                <p class="text-slate-700 mt-1"><span class="text-slate-400">Periode:</span> <span class="font-mono font-bold text-slate-900">{{ $iuranWarga->periode }}</span></p>
                <p class="text-slate-700 mt-1"><span class="text-slate-400">Tanggal Dibuat:</span> <span class="font-medium text-slate-800">{{ $iuranWarga->created_at->translatedFormat('d M Y') }}</span></p>
            </div>
        </div>

        <!-- Item Tagihan Table -->
        <div class="border border-slate-200/90 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5">Uraian Retribusi</th>
                        <th class="px-5 py-3.5">Periode</th>
                        <th class="px-5 py-3.5 text-right">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="px-5 py-4 font-bold text-slate-800">
                            {{ $iuranWarga->jenisIuran->nama_iuran }}
                            @if ($iuranWarga->jenisIuran->deskripsi)
                                <span class="block text-[11px] text-slate-400 font-normal mt-0.5">{{ $iuranWarga->jenisIuran->deskripsi }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 font-mono text-slate-600">
                            <span class="bg-slate-100 px-2 py-0.5 rounded text-[11px] font-semibold">{{ $iuranWarga->periode }}</span>
                        </td>
                        <td class="px-5 py-4 text-right font-mono font-bold text-slate-900 text-sm">
                            Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-slate-50/80 font-bold border-t border-slate-200 text-slate-900 text-xs">
                    <tr>
                        <td colspan="2" class="px-5 py-3.5 text-right uppercase tracking-wider text-slate-600">Total Yang Harus Dibayar:</td>
                        <td class="px-5 py-3.5 text-right text-base text-indigo-700 font-mono font-bold">Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="p-4 sm:p-5 rounded-xl bg-slate-50/70 border border-slate-100 text-xs space-y-2">
            <h4 class="font-bold text-slate-800 uppercase tracking-wider text-[11px]">Status & Pembayaran</h4>
            @if ($iuranWarga->status_pembayaran === 'lunas')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Bayar:</span>
                        <span class="font-bold text-emerald-700 font-mono mt-0.5 block">{{ $iuranWarga->tanggal_pembayaran ? $iuranWarga->tanggal_pembayaran->translatedFormat('d F Y H:i') : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">Catatan:</span>
                        <span class="text-slate-700 mt-0.5 block">{{ $iuranWarga->catatan ?: '-' }}</span>
                    </div>
                </div>
            @else
                <p class="text-amber-800">
                    Tagihan ini masih berstatus <strong>Menunggu Pembayaran</strong>. Silakan selesaikan pembayaran dan verifikasi lunas.
                </p>
            @endif
        </div>

        <!-- Tombol Aksi Cepat Bayar / Batalkan -->
        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
            <div>
                <form action="{{ route('admin.iuran-warga.destroy', $iuranWarga) }}" method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus tagihan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                        Hapus Tagihan Ini
                    </button>
                </form>
            </div>
            <div>
                @if ($iuranWarga->status_pembayaran !== 'lunas')
                    <form action="{{ route('admin.iuran-warga.bayar', $iuranWarga) }}" method="POST" class="inline"
                          onsubmit="return confirm('Konfirmasi tandai tagihan ini sebagai LUNAS?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 rounded-xl shadow-sm shadow-emerald-600/20 hover:shadow-md transition">
                            Tandai Sebagai LUNAS
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.iuran-warga.batal-bayar', $iuranWarga) }}" method="POST" class="inline"
                          onsubmit="return confirm('Batalkan status pembayaran tagihan ini kembali ke MENUNGGU PEMBAYARAN?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 text-xs font-semibold text-amber-800 bg-amber-100 hover:bg-amber-200 rounded-xl transition">
                            Batalkan Status Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
