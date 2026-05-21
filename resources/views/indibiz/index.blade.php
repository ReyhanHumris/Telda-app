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
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('indibiz.trash') }}" class="px-4 py-2 bg-surface-container-high text-on-surface rounded-lg font-bold text-sm border border-outline-variant/30 hover:bg-error-container/20 hover:text-error transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">delete_history</span>
                Data Dihapus
            </a>
            <a href="{{ route('indibiz.print', request()->query()) }}" target="_blank" class="px-4 py-2 bg-secondary text-on-secondary rounded-lg font-bold text-sm shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">print</span>
                Cetak Laporan
            </a>
            <a href="{{ route('indibiz.create') }}" class="px-5 py-2.5 bg-gradient-to-br from-primary to-primary-dim text-on-primary rounded-lg font-bold text-sm shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Rekaman Baru
            </a>
        </div>
    </div>

    {{-- Overview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Klien -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-primary/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Total Klien</p>
            <h3 class="text-2xl font-extrabold mt-1 text-on-surface font-headline">{{ number_format($totalIndibiz) }}</h3>
            <div class="mt-2 text-[10px] text-primary font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">corporate_fare</span> Semua Perusahaan
            </div>
        </div>
        <!-- Aktif -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-success/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Layanan Aktif</p>
            <h3 class="text-2xl font-extrabold mt-1 text-primary font-headline">{{ number_format($aktifCount) }}</h3>
            <div class="mt-2 text-[10px] text-primary font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">check_circle</span> Berlangganan Aktif
            </div>
        </div>
        <!-- Nonaktif -->
        <div class="p-5 bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-error/5 rounded-full group-hover:scale-125 transition-transform"></div>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Layanan Nonaktif</p>
            <h3 class="text-2xl font-extrabold mt-1 text-error font-headline">{{ number_format($nonaktifCount) }}</h3>
            <div class="mt-2 text-[10px] text-error font-bold flex items-center gap-1 uppercase tracking-wider">
                <span class="material-symbols-outlined text-xs fill-icon">cancel</span> Tidak Berlangganan
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('indibiz.index') }}" class="flex flex-wrap items-center gap-3 mb-6 p-4 bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10">
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
            <input type="text" name="tipe" value="{{ request('tipe') }}" placeholder="Tipe Layanan..." class="border-outline-variant/30 rounded-lg text-sm focus:ring-primary focus:border-primary w-48">
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
            <a href="{{ route('indibiz.index') }}" class="px-4 py-2 bg-surface-container-highest text-on-surface rounded-lg text-sm font-bold hover:bg-surface-variant transition-colors">Reset</a>
        @endif
    </form>

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
                                    <form method="POST" action="{{ route('indibiz.destroy', $item->id_indibiz) }}" data-swal-confirm data-swal-title="Hapus Indibiz" data-swal-text="Hapus data klien Indibiz ini?" data-swal-confirm-btn="Ya, hapus" data-swal-icon="warning">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-on-surface-variant hover:text-error transition-colors rounded-lg" title="Hapus Data">
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