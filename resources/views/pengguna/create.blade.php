@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
            <span>Manajemen</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span>Kelola User</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Tambah Pengguna</span>
        </nav>
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Tambah Pengguna</h2>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('pengguna.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="p-8 space-y-6">
                <!-- Premium Photo Upload Section -->
                <div class="flex items-center gap-6 mb-6">
                    <div class="relative group">
                        <div id="avatar-placeholder" class="w-24 h-24 rounded-full bg-primary-container text-primary flex items-center justify-center text-3xl font-bold border-4 border-surface-container shadow-md">
                            ?
                        </div>
                        <img id="avatar-preview" src="" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-surface-container shadow-md hidden">
                        <label for="foto" class="absolute inset-0 bg-black/50 text-white rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                            <span class="material-symbols-outlined">photo_camera</span>
                            <span class="text-[10px] font-bold uppercase mt-1">Ubah Foto</span>
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-on-surface">Foto Profil</h3>
                        <p class="text-xs text-on-surface-variant mb-2">Unggah foto profil untuk pengguna baru ini.</p>
                        <label for="foto" class="inline-flex items-center gap-1.5 px-3 py-1 bg-surface-container-high hover:bg-surface-container text-on-surface text-xs font-bold rounded-lg cursor-pointer transition-all border border-outline-variant/30">
                            <span class="material-symbols-outlined text-sm">upload</span>
                            Pilih Foto Profil
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Role</label>
                    <select name="role" required class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                        <option value="officer" @selected(old('role') === 'officer')>Officer (Petugas Lapangan)</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 p-3 text-sm rounded-t-lg">
                    </div>
                </div>


            </div>

            <div class="p-6 bg-surface-container-low border-t border-outline-variant/10 flex gap-4 justify-end">
                <a href="{{ route('pengguna.index') }}" class="px-6 py-2 text-on-surface-variant font-bold text-sm hover:bg-surface-container-highest rounded-lg transition-colors">Batal</a>
                <button type="submit" class="bg-primary px-8 py-2 rounded-lg text-white font-bold text-sm shadow-sm hover:bg-primary-dim transition-colors">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const placeholder = document.getElementById('avatar-placeholder');
                
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Pratinjau foto diperbarui.',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        }
    }
</script>
@endpush
