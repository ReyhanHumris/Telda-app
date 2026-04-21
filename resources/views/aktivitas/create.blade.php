@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <div class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Input Aktivitas</div>
        <div class="text-on-surface-variant font-body mt-1">Sesuai flowchart: admin mengelola aktivitas.</div>
    </div>

    <div class="max-w-2xl bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/20">
        <form method="POST" action="{{ route('aktivitas.store') }}" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Nama Aktivitas</label>
                <input name="nama_aktivitas" value="{{ old('nama_aktivitas') }}" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20" />
            </div>

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Tanggal Aktivitas</label>
                <input name="tanggal_aktivitas" type="date" value="{{ old('tanggal_aktivitas') }}" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20" />
            </div>

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Keterangan</label>
                <textarea name="keterangan" rows="4"
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold hover:opacity-90">
                    Simpan
                </button>
                <a href="{{ route('aktivitas.index') }}" class="px-4 py-2 rounded-lg border border-outline-variant/50 hover:bg-surface-container-low">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection

