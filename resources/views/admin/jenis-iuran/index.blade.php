@extends('layouts.dashboard')

@section('title', 'Master Jenis Iuran')
@section('page_heading', 'Master Data Jenis Iuran')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Master Jenis Iuran</h1>
            </div>
            <p class="text-xs text-slate-500 mt-1 pl-10">Kelola master tarif retribusi / iuran lingkungan (kebersihan, keamanan, kas, sosial, dll).</p>
        </div>
        <div class="flex items-center gap-2 pl-10 sm:pl-0">
            <a href="{{ route('admin.jenis-iuran.create') }}"
               class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 rounded-xl shadow-sm shadow-indigo-600/20 hover:shadow-md hover:shadow-indigo-600/25 transition-all duration-150">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jenis Iuran
            </a>
        </div>
    </div>

    <!-- Tabel Data Jenis Iuran -->
    <div class="bg-white rounded-2xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold text-[11px]">
                    <tr>
                        <th class="px-5 py-3.5 w-12 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Iuran</th>
                        <th class="px-5 py-3.5">Nominal Tarif</th>
                        <th class="px-5 py-3.5">Deskripsi</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Total Tagihan</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jenisIurans as $index => $jenis)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-mono">
                                {{ $jenisIurans->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.jenis-iuran.show', $jenis) }}" class="hover:text-indigo-600 transition inline-flex items-center gap-2">
                                    <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center text-[11px] border border-indigo-100">
                                        Rp
                                    </span>
                                    <span>{{ $jenis->nama_iuran }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900 font-mono text-sm">
                                Rp {{ number_format($jenis->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 max-w-xs truncate">
                                {{ $jenis->deskripsi ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($jenis->is_aktif)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200/70">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    <span class="font-mono">{{ $jenis->iuran_wargas_count }}</span> Tagihan
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.jenis-iuran.show', $jenis) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 hover:text-indigo-600 bg-slate-100/80 hover:bg-slate-200/80 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.jenis-iuran.edit', $jenis) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.jenis-iuran.destroy', $jenis) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis iuran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-700">Belum ada master jenis iuran</p>
                                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Silakan tambahkan jenis iuran baru seperti Iuran Kebersihan, Keamanan, atau Kas Lingkungan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jenisIurans->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-slate-50/50">
                {{ $jenisIurans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
