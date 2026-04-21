@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <div class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Data Indibiz</div>
            <div class="text-on-surface-variant font-body mt-1">
                @can('admin')
                    Menampilkan semua data.
                @else
                    Menampilkan data milik Anda.
                @endcan
            </div>
        </div>
        <a href="{{ route('indibiz.create') }}" class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold hover:opacity-90">
            Input Data Indibiz
        </a>
    </div>

    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-surface-container-low text-on-surface">
                <tr>
                    <th class="text-left px-4 py-3">Perusahaan</th>
                    <th class="text-left px-4 py-3">Jenis Layanan</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Input oleh</th>
                    <th class="text-left px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20 bg-surface-container-lowest">
                @forelse ($items as $item)
                    <tr>
                        <td class="px-4 py-3">
                            <div class="font-medium">{{ $item->nama_perusahaan }}</div>
                            <div class="text-on-surface-variant text-xs mt-1 line-clamp-2">{{ $item->alamat_perusahaan }}</div>
                        </td>
                        <td class="px-4 py-3">{{ $item->jenis_layanan }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs border border-outline-variant bg-surface-container text-on-surface">
                                {{ $item->status_langganan }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-on-surface-variant">{{ $item->pengguna?->nama_lengkap }}</td>
                        <td class="px-4 py-3 text-on-surface-variant">{{ optional($item->tanggal_input)->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('indibiz.destroy', $item) }}" onsubmit="return confirm('Hapus data Indibiz ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 rounded-lg border border-error/30 text-error hover:bg-error/10">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-slate-400">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

