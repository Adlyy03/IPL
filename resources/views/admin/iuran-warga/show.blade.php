@extends('layouts.dashboard')

@section('title', 'Detail Tagihan Iuran #' . $iuranWarga->id)
@section('page_heading', 'Detail Transaksi Iuran Warga')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.iuran-warga.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">&larr; Kembali ke Daftar Tagihan</a>
            </div>
            <h1 class="text-xl font-bold text-slate-900 mt-1">Invoice Tagihan #IPL-{{ str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-xs text-slate-500 mt-0.5">Diterbitkan untuk {{ $iuranWarga->warga->nama_lengkap }} periode {{ $iuranWarga->periode }}.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.iuran-warga.edit', $iuranWarga) }}"
               class="inline-flex items-center px-3 py-2 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <button onclick="window.print()"
                    class="inline-flex items-center px-3 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Bukti
            </button>
        </div>
    </div>

    <!-- Lembar Tagihan / Invoice Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="inline-flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">IPL</div>
                    <span class="font-bold text-slate-900 text-sm">Sistem Iuran Pengelolaan Lingkungan</span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Perumahan / Lingkungan Warga Terpadu</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="text-[11px] font-semibold text-slate-400 block uppercase tracking-wider">Status Tagihan</span>
                @if ($iuranWarga->status_pembayaran === 'lunas')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 mt-1">
                        &bull; LUNAS
                    </span>
                @elseif ($iuranWarga->status_pembayaran === 'batal')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 mt-1">
                        &bull; BATAL
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 mt-1">
                        &bull; MENUNGGU PEMBAYARAN
                    </span>
                @endif
            </div>
        </div>

        <!-- Detail Warga & Periode -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div>
                <span class="text-slate-400 font-semibold uppercase tracking-wider block text-[10px]">Ditagihkan Kepada:</span>
                <p class="font-bold text-slate-900 text-sm mt-1">{{ $iuranWarga->warga->nama_lengkap }}</p>
                <p class="text-slate-600 mt-0.5">Blok {{ $iuranWarga->warga->blok->nama_blok }} No. {{ $iuranWarga->warga->blok->nomor_rumah }}</p>
                <p class="text-slate-500">{{ $iuranWarga->warga->blok->gang->nama_gang }}</p>
                <p class="text-slate-500 font-mono mt-1">No. HP: {{ $iuranWarga->warga->nomor_hp ?: '-' }}</p>
            </div>
            <div class="sm:text-right">
                <span class="text-slate-400 font-semibold uppercase tracking-wider block text-[10px]">Rincian Transaksi:</span>
                <p class="text-slate-700 mt-1"><span class="text-slate-400">No. Tagihan:</span> #IPL-{{ str_pad($iuranWarga->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p class="text-slate-700 mt-0.5"><span class="text-slate-400">Periode:</span> <strong>{{ $iuranWarga->periode }}</strong></p>
                <p class="text-slate-700 mt-0.5"><span class="text-slate-400">Tanggal Dibuat:</span> {{ $iuranWarga->created_at->translatedFormat('d M Y') }}</p>
            </div>
        </div>

        <!-- Item Tagihan Table -->
        <div class="border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Uraian Retribusi</th>
                        <th class="px-4 py-3">Periode</th>
                        <th class="px-4 py-3 text-right">Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="px-4 py-3.5 font-bold text-slate-800">
                            {{ $iuranWarga->jenisIuran->nama_iuran }}
                            @if ($iuranWarga->jenisIuran->deskripsi)
                                <span class="block text-[11px] text-slate-400 font-normal">{{ $iuranWarga->jenisIuran->deskripsi }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 font-mono text-slate-600">
                            {{ $iuranWarga->periode }}
                        </td>
                        <td class="px-4 py-3.5 text-right font-bold text-slate-900 text-sm">
                            Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-slate-50 font-bold border-t border-slate-200 text-slate-900 text-xs">
                    <tr>
                        <td colspan="2" class="px-4 py-3 text-right uppercase tracking-wider">Total Yang Harus Dibayar:</td>
                        <td class="px-4 py-3 text-right text-base text-indigo-700">Rp {{ number_format($iuranWarga->nominal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-xs space-y-2">
            <h4 class="font-bold text-slate-800">Status & Pembayaran</h4>
            @if ($iuranWarga->status_pembayaran === 'lunas')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <span class="text-slate-400 block text-[11px]">Tanggal Bayar:</span>
                        <span class="font-bold text-slate-800">{{ $iuranWarga->tanggal_pembayaran ? $iuranWarga->tanggal_pembayaran->translatedFormat('d F Y H:i') : '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[11px]">Catatan:</span>
                        <span class="text-slate-700">{{ $iuranWarga->catatan ?: '-' }}</span>
                    </div>
                </div>
            @else
                <p class="text-amber-800">
                    Tagihan ini masih berstatus <strong>Menunggu Pembayaran</strong>.
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
                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800">
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
                                class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition">
                            Tandai Sebagai LUNAS
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.iuran-warga.batal-bayar', $iuranWarga) }}" method="POST" class="inline"
                          onsubmit="return confirm('Batalkan status pembayaran tagihan ini kembali ke MENUNGGU PEMBAYARAN?');">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 text-xs font-semibold text-amber-800 bg-amber-100 hover:bg-amber-200 rounded-xl transition">
                            Batalkan Status Pembayaran
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
