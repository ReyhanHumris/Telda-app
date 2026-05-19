@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Profil Saya</h2>
        <p class="text-on-surface-variant mt-1 font-body">Perbarui informasi dasar profil dan pengaturan akun Anda.</p>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-8 space-y-8">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        @if ($user->foto)
                            <img src="{{ $user->foto_url }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border-4 border-surface-container shadow-md">
                        @else
                            <div class="w-24 h-24 rounded-full bg-primary-container text-primary flex items-center justify-center text-3xl font-bold border-4 border-surface-container shadow-md">
                                {{ $user->inisial() }}
                            </div>
                        @endif
                        <label for="foto" class="absolute inset-0 bg-black/50 text-white rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                            <span class="material-symbols-outlined">photo_camera</span>
                            <span class="text-[10px] font-bold uppercase mt-1">Ubah Foto</span>
                        </label>
                        <input type="file" id="foto" name="foto" class="hidden" accept="image/*" onchange="previewImage(this)">
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-on-surface">{{ $user->nama_lengkap }}</h3>
                        <p class="text-sm text-on-surface-variant">{{ $user->role }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-outline-variant/10 pt-8">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Password Baru</label>
                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah"
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg">
                    </div>
                </div>
            </div>

            <div class="p-6 bg-surface-container-low border-t border-outline-variant/10 flex gap-4 justify-end">
                <button type="submit" class="bg-primary px-8 py-2 rounded-lg text-white font-bold text-sm shadow-sm hover:bg-primary-dim transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            // Kita bisa tambahkan preview gambar lokal di sini jika mau
            // Untuk saat ini biar sederhana, form disubmit manual atau cukup tahu file sudah dipilih.
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: 'Foto siap diunggah, silakan klik Simpan Perubahan.',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }
</script>
@endpush
@endsection
