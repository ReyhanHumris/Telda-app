@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface font-headline">Indibiz Dihapus</h2>
            <p class="text-on-surface-variant mt-1">Daftar data Indibiz yang berada di tempat sampah.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('indibiz.index') }}" class="px-4 py-2 bg-surface-container-high text-on-surface rounded-lg font-bold text-sm border border-outline-variant/30 hover:bg-surface-variant transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Data Aktif
            </a>
        </div>
    </div>



    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border border-outline-variant/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Nama Perusahaan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Tipe Layanan</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Input Oleh</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high">
                    @forelse ($items as $item)
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-primary-container flex items-center justify-center text-primary font-bold text-xs">
                                        {{ substr($item->nama_perusahaan, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-on-surface text-sm">{{ $item->nama_perusahaan }}</p>
                                        <p class="text-[11px] text-on-surface-variant line-clamp-1">{{ $item->alamat_perusahaan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 bg-secondary-container text-on-secondary-container rounded-md text-[10px] font-bold uppercase tracking-tight">
                                    {{ $item->jenis_layanan }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-1.5 text-xs font-bold {{ $item->status_langganan == 'Aktif' ? 'text-primary' : 'text-outline' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $item->status_langganan == 'Aktif' ? 'bg-primary animate-pulse' : 'bg-outline' }}"></span>
                                    {{ $item->status_langganan }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm text-on-surface font-medium">{{ $item->pengguna?->nama_lengkap }}</p>
                                <p class="text-[10px] text-on-surface-variant">{{ optional($item->tanggal_input)->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('indibiz.restore', $item->id_indibiz) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-primary text-on-primary rounded-lg text-xs font-bold hover:bg-primary-dim transition-all">Pulihkan</button>
                                    </form>
                                    <form method="POST" action="{{ route('indibiz.forceDelete', $item->id_indibiz) }}" onsubmit="return confirm('Hapus permanen data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-error hover:bg-error/10 transition-colors rounded-lg">
                                            <span class="material-symbols-outlined text-lg">delete_forever</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-outline-variant">delete</span>
                                    <p class="text-on-surface-variant">Trash Indibiz kosong.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
{{-- Ganti baris 107-111 dengan ini --}}
@if(method_exists($items, 'hasPages') && $items->hasPages())
    <div class="px-6 py-4 bg-surface-container-low border-t border-surface-container-high">
        {{ $items->links() }}
    </div>
@endif
    </div>
@endsection