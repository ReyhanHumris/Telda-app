@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-on-surface font-headline">Data Indibiz</h2>
            <p class="text-on-surface-variant mt-1">
                @can('admin')
                    Kelola langganan layanan korporat dan profil klien regional Labuan Bajo.
                @else
                    Menampilkan data langganan milik Anda.
                @endcan
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-surface-container-high text-on-secondary-container rounded-lg font-semibold text-sm hover:bg-surface-container-highest transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">filter_list</span>
                Filter
            </button>
            <a href="{{ route('indibiz.create') }}" class="px-5 py-2.5 bg-gradient-to-br from-primary to-primary-dim text-on-primary rounded-lg font-bold text-sm shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Rekaman Baru
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="p-5 bg-surface-container-lowest rounded-xl shadow-sm border-b-2 border-primary/20">
            <p class="text-[11px] uppercase tracking-wider text-on-surface-variant font-bold">Total Klien</p>
            <h3 class="text-2xl font-black mt-1 text-on-surface font-headline">{{ number_format($indibizTotal ?? count($items)) }}</h3>
            <div class="mt-2 text-xs text-primary font-semibold flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">trending_up</span> Data Real-time
            </div>
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
                                    <a href="#" class="p-2 text-on-surface-variant hover:text-primary transition-colors rounded-lg">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('indibiz.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-on-surface-variant hover:text-error transition-colors rounded-lg">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-4xl text-outline-variant">database_off</span>
                                    <p class="text-on-surface-variant">Belum ada data Indibiz yang tercatat.</p>
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