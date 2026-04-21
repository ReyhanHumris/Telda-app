@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <div class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Input Survey Indibiz</div>
        <div class="text-on-surface-variant font-body mt-1">Simpan hasil survey.</div>
    </div>

    <div class="max-w-2xl bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/20">
        <form method="POST" action="{{ route('survey.store') }}" class="space-y-4">
            @csrf

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Nama Responden</label>
                <input name="nama_responden" value="{{ old('nama_responden') }}" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="space-y-1">
                    <label class="text-sm text-on-surface">No Telepon</label>
                    <input name="no_telepon" value="{{ old('no_telepon') }}" required
                        class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20"
                        placeholder="08xxxxxxxxxx" />
                </div>
                <div class="space-y-1">
                    <label class="text-sm text-on-surface">Hasil Survey</label>
                    <select name="hasil_survey" required
                        class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20">
                        <option value="berminat" @selected(old('hasil_survey') === 'berminat')>berminat</option>
                        <option value="pikir-pikir" @selected(old('hasil_survey') === 'pikir-pikir')>pikir-pikir</option>
                        <option value="tidak berminat" @selected(old('hasil_survey') === 'tidak berminat')>tidak berminat</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-sm text-on-surface">Kriteria</label>
                <input name="kriteria" value="{{ old('kriteria') }}" required
                    class="w-full rounded-lg border-outline-variant/40 bg-surface-container-lowest focus:border-primary focus:ring-primary/20"
                    placeholder="contoh: Peluang upgrade, kebutuhan bandwidth, dll" />
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-primary text-on-primary rounded-lg text-sm font-semibold hover:opacity-90">
                    Simpan
                </button>
                <a href="{{ route('survey.index') }}" class="px-4 py-2 rounded-lg border border-outline-variant/50 hover:bg-surface-container-low">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection

