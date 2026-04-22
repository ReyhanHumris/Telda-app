@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
                <span>Sistem</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Log Aktivitas</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Aktivitas Sistem</h2>
            <p class="text-on-surface-variant mt-1 font-body">Pantau riwayat perubahan dan aktivitas operasional secara real-time.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('aktivitas.create') }}" class="flex items-center gap-2 px-5 py-2 bg-primary rounded-xl text-sm font-bold text-on-primary shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined text-sm">add</span>
                Input Aktivitas
            </a>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Waktu & Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Pengguna</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Aksi/Modul</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Keterangan</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high bg-surface-container-lowest">
                    @forelse ($items as $item)
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-6 py-5">
                                <div class="text-sm font-semibold text-on-surface">
                                    {{ optional($item->tanggal_aktivitas)->format('d M Y') ?? '-' }}
                                </div>
                                <div class="text-[11px] text-on-surface-variant">
                                    {{ optional($item->tanggal_aktivitas)->format('H:i') ?? '00:00' }} WITA
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container text-xs font-bold">
                                        {{ strtoupper(substr($item->pengguna?->nama_lengkap ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-on-surface">{{ $item->pengguna?->nama_lengkap ?? 'Unknown' }}</div>
                                        <div class="text-[10px] text-primary font-semibold uppercase tracking-tight">
                                            {{ $item->pengguna?->role ?? 'User' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <span class="px-2.5 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold uppercase tracking-tight">
                                    {{ $item->nama_aktivitas }}
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="text-sm text-on-surface-variant max-w-xs truncate" title="{{ $item->keterangan }}">
                                    {{ $item->keterangan }}
                                </div>
                            </td>

                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form method="POST" action="{{ route('aktivitas.destroy', $item) }}" onsubmit="return confirm('Hapus aktivitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <span class="material-symbols-outlined text-5xl mb-2">history_toggle_off</span>
                                    <p class="text-sm font-medium">Belum ada data aktivitas tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($items, 'hasPages') && $items->hasPages())
            <div class="px-6 py-4 border-t border-surface-container-high flex items-center justify-between bg-surface-container-low/30">
                <p class="text-[11px] text-on-surface-variant font-bold uppercase tracking-widest">
                    Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
                </p>
                <div class="flex items-center gap-1">
                    {{ $items->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection