@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <div class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Input Data Indibiz</div>
        <div class="text-on-surface-variant font-body mt-1">Simpan data Indibiz ke database.</div>
    </div>

    <div class="max-w-2xl bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/20">
        <form method="POST" action="{{ route('indibiz.store') }}" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Nama Perusahaan</label>
                <input name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20" />
            </div>

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Alamat Perusahaan</label>
                <textarea name="alamat_perusahaan" rows="4" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20">{{ old('alamat_perusahaan') }}</textarea>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="space-y-1">
                    <label class="text-sm text-on-surface">Jenis Layanan</label>
                    <input name="jenis_layanan" value="{{ old('jenis_layanan') }}" required
                        class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20"
                        placeholder="contoh: Internet Bisnis" />
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-on-surface">Status Langganan</label>
                    <select name="status_langganan" required
                        class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20">
                        <option value="aktif" @selected(old('status_langganan', 'aktif') === 'aktif')>aktif</option>
                        <option value="nonaktif" @selected(old('status_langganan') === 'nonaktif')>nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold hover:opacity-90">
                    Simpan
                </button>
                <a href="{{ route('indibiz.index') }}" class="px-4 py-2 rounded-lg border border-outline-variant/50 hover:bg-surface-container-low">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection

