@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
            <span>Manajemen</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span>Kelola User</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Edit Pengguna</span>
        </nav>
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Edit Pengguna</h2>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('pengguna.update', $pengguna->id_pengguna) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">
                <div class="flex items-center gap-6 mb-6">
                    @include('partials.avatar', ['user' => $pengguna, 'size' => 'lg', 'class' => 'shadow-sm'])
                    <div>
                        <h3 class="text-lg font-bold">{{ $pengguna->nama_lengkap }}</h3>
                        <p class="text-sm text-on-surface-variant">{{ $pengguna->role }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pengguna->nama_lengkap) }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Username</label>
                        <input type="text" name="username" value="{{ old('username', $pengguna->username) }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Role</label>
                    <select name="role" required class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                        <option value="officer" @selected(old('role', $pengguna->role) === 'officer')>Officer (Petugas Lapangan)</option>
                        <option value="admin" @selected(old('role', $pengguna->role) === 'admin')>Admin</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-outline-variant/10 pt-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Ubah Foto Profil</label>
                    <input type="file" name="foto" accept="image/*" class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                </div>
            </div>

            <div class="p-6 bg-surface-container-low border-t border-outline-variant/10 flex gap-4 justify-end">
                <a href="{{ route('pengguna.index') }}" class="px-6 py-2 text-on-surface-variant font-bold text-sm hover:bg-surface-container-highest rounded-lg transition-colors">Batal</a>
                <button type="submit" class="bg-primary px-8 py-2 rounded-lg text-white font-bold text-sm shadow-sm hover:bg-primary-dim transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
