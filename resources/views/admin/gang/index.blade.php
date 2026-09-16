@extends('layouts.dashboard')

@section('title', 'Manajemen Gang')
@section('page_heading', 'Master Data Gang')

@section('content')
<div class="space-y-6">
    <!-- Header & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Data Gang & Wilayah</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola daftar gang, lorong, dan jalan di lingkungan perumahan.</p>
        </div>
        <a href="{{ route('admin.gang.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition duration-150 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Gang Baru</span>
        </a>
    </div>

    <!-- Tabel Data Gang -->
    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] text-slate-500 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-5 py-3.5 w-14 text-center">No</th>
                        <th class="px-5 py-3.5">Nama Gang</th>
                        <th class="px-5 py-3.5">Keterangan</th>
                        <th class="px-5 py-3.5 text-center">Jumlah Blok</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse ($gangs as $index => $gang)
                        <tr class="hover:bg-slate-50/80 transition duration-150">
                            <td class="px-5 py-4 text-center text-slate-400 font-mono">
                                {{ $gangs->firstItem() + $index }}
                            </td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.gang.show', $gang) }}" class="font-bold text-slate-900 hover:text-indigo-600 text-sm transition">
                                    {{ $gang->nama_gang }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-slate-500 max-w-xs truncate">
                                {{ $gang->keterangan ?: '-' }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $gang->bloks_count }} Blok
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if ($gang->status === 'aktif')
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
                            <td class="px-5 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.gang.show', $gang) }}"
                                       class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-100 hover:bg-slate-200/80 rounded-lg transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.gang.edit', $gang) }}"
                                       class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-indigo-700 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100/80 rounded-lg transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.gang.destroy', $gang) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-rose-700 hover:text-rose-900 bg-rose-50 hover:bg-rose-100/80 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-2">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-800">Belum Ada Data Gang</h4>
                                    <p class="text-xs text-slate-400">Belum ada gang atau jalan yang terdaftar di sistem.</p>
                                    <div class="pt-2">
                                        <a href="{{ route('admin.gang.create') }}"
                                           class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition">
                                            Tambah Gang Sekarang
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($gangs->hasPages())
            <div class="p-4 border-t border-slate-200/80 bg-slate-50/40">
                {{ $gangs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
