@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-extrabold">Pengguna Terhapus</h2>
            <p class="text-on-surface-variant mt-1">Mengelola pengguna yang dihapus (soft deleted).</p>
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
                                    <form method="POST" action="{{ route('pengguna.restore', $item->id_pengguna) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 rounded-lg bg-primary text-on-primary">Pulihkan</button>
                                    </form>

                                    <form method="POST" action="{{ route('pengguna.forceDelete', $item->id_pengguna) }}" onsubmit="return confirm('Hapus permanen pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-2 rounded-lg bg-error text-on-error">Hapus Permanen</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
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
