@extends('layouts.dashboard')

@section('title', 'Master Jenis Iuran')
@section('page_heading', 'Master Data Jenis Iuran')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Master Jenis Iuran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola jenis-jenis retribusi / iuran lingkungan (kebersihan, keamanan, kas, dll).</p>
        </div>
        <a href="{{ route('admin.jenis-iuran.create') }}"
           class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jenis Iuran
        </a>
    </div>

    <!-- Tabel Data Jenis Iuran -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
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
                            <td class="px-5 py-3.5 text-center text-slate-400">
                                {{ $jenisIurans->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <a href="{{ route('admin.jenis-iuran.show', $jenis) }}" class="hover:text-indigo-600">
                                    {{ $jenis->nama_iuran }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-800">
                                Rp {{ number_format($jenis->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $jenis->deskripsi ?: '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if ($jenis->is_aktif)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $jenis->iuran_wargas_count }} Tagihan
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('admin.jenis-iuran.show', $jenis) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                    Detail
                                </a>
                                <a href="{{ route('admin.jenis-iuran.edit', $jenis) }}"
                                   class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.jenis-iuran.destroy', $jenis) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis iuran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-slate-400">
                                Belum ada master jenis iuran yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($jenisIurans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $jenisIurans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
