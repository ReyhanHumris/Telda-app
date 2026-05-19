@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-extrabold text-on-surface font-headline">Kelola Pengguna</h2>
            <p class="text-on-surface-variant mt-1">Daftar akun pengguna aktif.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pengguna.trashed') }}" class="px-4 py-2 bg-surface-container-high text-on-surface rounded-lg font-bold text-sm border border-outline-variant/30 hover:bg-error-container/20 hover:text-error transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">delete_history</span>
                Data Dihapus
            </a>
            <a href="{{ route('pengguna.create') }}" class="px-5 py-2.5 bg-gradient-to-br from-primary to-primary-dim text-on-primary rounded-lg font-bold text-sm shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="bg-surface-container-lowest rounded-xl shadow-sm overflow-hidden border border-outline-variant/10">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low">
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Nama</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Username</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Role</th>
                        <th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container-high">
                    @forelse ($items as $item)
                        <tr class="hover:bg-surface-container-low transition-colors group">
                            <td class="px-6 py-5">{{ $item->nama_lengkap }}</td>
                            <td class="px-6 py-5">{{ $item->username }}</td>
                            <td class="px-6 py-5">{{ $item->role }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('pengguna.edit', $item) }}" class="p-2 text-on-surface-variant hover:text-primary transition-colors rounded-lg" title="Edit Pengguna">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    <form method="POST" action="{{ route('pengguna.destroy', $item) }}" onsubmit="return confirm('Hapus pengguna ini?')">
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
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-on-surface-variant">Belum ada pengguna terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($items, 'hasPages') && $items->hasPages())
            <div class="px-6 py-4 bg-surface-container-low border-t border-surface-container-high">
                {{ $items->links() }}
            </div>
        @endif
    </div>
@endsection
