@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
                <span>Operasional</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Survey Indibiz</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Survey Dihapus</h2>
            <p class="text-on-surface-variant mt-1 font-body">Daftar survey yang berada di tempat sampah.</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('survey.index') }}" class="flex items-center gap-2 px-5 py-2 bg-surface-container-high rounded-xl text-sm font-bold text-on-surface border border-outline-variant/30 hover:bg-surface-variant transition-all">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Kembali ke Data Aktif
            </a>
        </div>
    </div>



    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-center">Petugas</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Responden & Kontak</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Kriteria</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Hasil Survey</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Waktu Input</th>
                        <th class="px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high bg-surface-container-lowest text-sm">
                    @forelse ($items as $item)
                        <tr class="hover:bg-surface-container-low/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    {{-- Integrasi Foto Profil jika ada --}}
                                    @if($item->pengguna)
                                        @include('partials.avatar', ['user' => $item->pengguna, 'size' => 'sm', 'class' => 'ring-2 ring-surface shadow-sm'])
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-on-surface">{{ $item->nama_responden }}</div>
                                <div class="flex items-center gap-1 text-[11px] text-on-surface-variant mt-0.5">
                                    <span class="material-symbols-outlined text-[12px]">call</span>
                                    {{ $item->no_telepon }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 bg-surface-container-high text-on-surface rounded text-[10px] font-medium border border-outline-variant/30">
                                    {{ $item->kriteria }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClass = str_contains(strtolower($item->hasil_survey), 'tidak') 
                                        ? 'bg-error-container text-error' 
                                        : 'bg-primary-container text-primary';
                                @endphp
                                <span class="{{ $statusClass }} px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight">
                                    {{ $item->hasil_survey }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                {{-- Format Jam WITA sesuai permintaan sebelumnya --}}
                                <div class="text-on-surface font-medium">{{ optional($item->tanggal_input)->format('d/m/y') }}</div>
                                <div class="text-[10px] text-on-surface-variant italic">
                                    {{ optional($item->tanggal_input)->format('H:i') }} WITA
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <form method="POST" action="{{ route('survey.restore', $item->id_survey) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 bg-primary text-on-primary rounded-lg text-xs font-bold hover:bg-primary-dim transition-all">Pulihkan</button>
                                    </form>
                                    <form method="POST" action="{{ route('survey.forceDelete', $item->id_survey) }}" onsubmit="return confirm('Hapus permanen survey ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-error hover:bg-error/10 rounded-lg transition-all" title="Hapus Permanen">
                                            <span class="material-symbols-outlined text-lg">delete_forever</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center opacity-25">
                                    <span class="material-symbols-outlined text-6xl mb-3">delete</span>
                                    <p class="text-base font-bold">Trash Kosong</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($items, 'hasPages') && $items->hasPages())
            <div class="px-6 py-4 border-t border-surface-container-high bg-surface-container-low/20">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection