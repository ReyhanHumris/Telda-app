@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
        <div>
            <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
                <span>Operasional</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Survey Indibiz</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Data Survey</h2>
            <p class="text-on-surface-variant mt-1 font-body">
                @can('admin')
                    Manajemen seluruh data survey dari semua petugas di lapangan.
                @else
                    Daftar hasil survey yang telah Anda kumpulkan.
                @endcan
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('survey.trash') }}" class="flex items-center gap-2 px-5 py-2 bg-surface-container-high rounded-xl text-sm font-bold text-on-surface border border-outline-variant/30 hover:bg-error-container/20 hover:text-error transition-all">
                <span class="material-symbols-outlined text-sm">delete_history</span>
                Data Dihapus
            </a>

            <a href="{{ route('survey.print', request()->query()) }}" target="_blank" class="flex items-center gap-2 px-5 py-2 bg-secondary text-on-secondary rounded-xl text-sm font-bold shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak Laporan
            </a>

            <a href="{{ route('survey.create') }}" class="flex items-center gap-2 px-5 py-2 bg-primary rounded-xl text-sm font-bold text-on-primary shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                <span class="material-symbols-outlined text-sm">add_task</span>
                Input Survey Baru
            </a>
        </div>
    </div>
    {{-- Overview Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Survey -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-primary/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Total Survey</p>
            <h3 class="text-2xl font-extrabold mt-1 text-on-surface font-headline">{{ number_format($totalSurvey) }}</h3>
            <div class="mt-2 text-[10px] text-primary font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">poll</span> Semua Responden
            </div>
        </div>
        <!-- Berminat -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-success/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Berminat</p>
            <h3 class="text-2xl font-extrabold mt-1 text-primary font-headline">{{ number_format($berminatCount) }}</h3>
            <div class="mt-2 text-[10px] text-primary font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">check_circle</span> Tertarik Layanan
            </div>
        </div>
        <!-- Pikir-pikir -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-warning/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Pikir-pikir</p>
            <h3 class="text-2xl font-extrabold mt-1 text-secondary font-headline">{{ number_format($pikirCount) }}</h3>
            <div class="mt-2 text-[10px] text-secondary font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">pending</span> Butuh Follow Up
            </div>
        </div>
        <!-- Tidak Berminat -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-error/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Tidak Berminat</p>
            <h3 class="text-2xl font-extrabold mt-1 text-error font-headline">{{ number_format($tidakBerminatCount) }}</h3>
            <div class="mt-2 text-[10px] text-error font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">cancel</span> Menolak Layanan
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('survey.index') }}" class="flex flex-wrap items-center gap-3 mb-6 p-4 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-outline">calendar_month</span>
            <select name="bulan" class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-36">
                <option value="">Bulan...</option>
                @php
                    $months = ['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'];
                @endphp
                @foreach($months as $key => $name)
                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            <select name="tahun" class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-28">
                <option value="">Tahun...</option>
                @php $currentYear = date('Y'); @endphp
                @foreach(range($currentYear, $currentYear - 5) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-outline">category</span>
            <select name="tipe" class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-48">
                <option value="">Semua Hasil Survey</option>
                <option value="berminat" {{ request('tipe') == 'berminat' ? 'selected' : '' }}>Berminat</option>
                <option value="pikir-pikir" {{ request('tipe') == 'pikir-pikir' ? 'selected' : '' }}>Pikir-pikir</option>
                <option value="tidak berminat" {{ request('tipe') == 'tidak berminat' ? 'selected' : '' }}>Tidak Berminat</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-outline">group</span>
            <select name="petugas" class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-48">
                <option value="">Semua Petugas</option>
                @foreach($usersList as $u)
                    <option value="{{ $u->id_pengguna }}" {{ request('petugas') == $u->id_pengguna ? 'selected' : '' }}>{{ $u->nama_lengkap }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-outline">format_list_bulleted</span>
            <select name="limit" onchange="this.form.submit()" class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-28">
                <option value="5" {{ request('limit') == 5 ? 'selected' : '' }}>5 Data</option>
                <option value="10" {{ request('limit') == 10 || !request('limit') ? 'selected' : '' }}>10 Data</option>
                <option value="20" {{ request('limit') == 20 ? 'selected' : '' }}>20 Data</option>
                <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25 Data</option>
            </select>
        </div>

        <button type="submit" class="px-4 py-2 bg-secondary text-on-secondary rounded-lg text-sm font-bold shadow-sm hover:bg-secondary-dim transition-colors">Filter</button>
        @if(request('bulan') || request('tahun') || request('tipe') || request('petugas') || request('limit'))
            <a href="{{ route('survey.index') }}" class="px-4 py-2 bg-surface-container-highest text-on-surface rounded-lg text-sm font-bold hover:bg-surface-variant transition-colors">Reset</a>
        @endif
    </form>

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
                                <div class="flex flex-col gap-1">
                                    <span class="inline-block px-2 py-0.5 w-max bg-surface-container-high text-on-surface rounded text-[10px] font-bold border border-outline-variant/30 uppercase tracking-tighter">
                                        {{ $item->kriteria }}
                                    </span>
                                    @if($item->kecamatan)
                                        <div class="text-[11px] font-bold text-primary flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[12px] fill-icon">location_on</span>
                                            {{ $item->kecamatan }}
                                        </div>
                                    @endif
                                    @if($item->alamat_detail)
                                        <div class="text-[10px] text-on-surface-variant line-clamp-1 max-w-[200px]" title="{{ $item->alamat_detail }}">
                                            {{ $item->alamat_detail }}
                                        </div>
                                    @endif
                                </div>
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
                                    <form method="POST" action="{{ route('survey.destroy', $item->id_survey) }}" data-swal-confirm data-swal-title="Hapus Survey" data-swal-text="Pindahkan data ke tempat sampah?" data-swal-confirm-btn="Ya, hapus" data-swal-icon="warning">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-error hover:bg-error/10 rounded-lg transition-all" title="Hapus (Pindah ke Trash)">
                                            <span class="material-symbols-outlined text-lg">delete_sweep</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center opacity-25">
                                    <span class="material-symbols-outlined text-6xl mb-3">query_stats</span>
                                    <p class="text-base font-bold">Data Survey Kosong</p>
                                    <p class="text-xs">Mulai kumpulkan data dari lapangan hari ini.</p>
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