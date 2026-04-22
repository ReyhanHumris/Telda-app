@extends('layouts.admin')

@section('content')
    <div class="mb-8">
        <nav class="flex items-center gap-2 text-xs text-on-secondary-fixed-variant mb-2 uppercase tracking-widest font-semibold">
            <span>Operasional</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Input Survey Baru</span>
        </nav>
        <h2 class="text-3xl font-extrabold text-on-surface tracking-tight font-headline">Entri Survei Baru</h2>
        <p class="text-on-surface-variant mt-1 font-body">Isi detail responden untuk memperbarui sistem manajemen data presisi.</p>
    </div>

    <div class="max-w-3xl bg-surface-container-lowest rounded-2xl shadow-xl shadow-surface-dim/20 border border-outline-variant/10 overflow-hidden">
        <form method="POST" action="{{ route('survey.store') }}">
            @csrf

            <div class="p-8 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nama Responden</label>
                        <input type="text" name="nama_responden" value="{{ old('nama_responden') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="misal: Agus Ardiansyah">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Nomor Telepon</label>
                        <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" required
                            class="w-full bg-surface-container-high border-0 border-b-2 border-outline-variant focus:border-primary focus:ring-0 transition-colors p-3 text-sm rounded-t-lg" 
                            placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Tipe Kriteria</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['Residensial' => 'home', 'Bisnis Kecil' => 'store', 'Perusahaan' => 'corporate_fare'] as $label => $icon)
                            <label class="cursor-pointer group">
                                <input type="radio" name="kriteria" value="{{ $label }}" class="hidden peer" required @checked(old('kriteria') === $label)>
                                <div class="border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary-container/10 p-4 rounded-xl text-center transition-all group-hover:bg-surface-container flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant peer-checked:text-primary">{{ $icon }}</span>
                                    <span class="text-[11px] font-bold text-on-surface-variant peer-checked:text-primary uppercase tracking-tighter">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-xs font-bold text-on-surface-variant uppercase tracking-widest">Hasil Survei</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="berminat" class="text-primary focus:ring-primary w-5 h-5" required @checked(old('hasil_survey') === 'berminat')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-emerald-700 leading-none">Berminat</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Minat segera, siap untuk tindak lanjut</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="pikir-pikir" class="text-primary focus:ring-primary w-5 h-5" @checked(old('hasil_survey') === 'pikir-pikir')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-amber-700 leading-none">Pikir-pikir</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Membutuhkan informasi lebih lanjut atau cek anggaran</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 rounded-xl bg-surface-container-low border-2 border-transparent hover:border-primary/20 cursor-pointer transition-all has-[:checked]:border-primary/40 has-[:checked]:bg-white">
                            <input type="radio" name="hasil_survey" value="tidak berminat" class="text-primary focus:ring-primary w-5 h-5" @checked(old('hasil_survey') === 'tidak berminat')>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-500 leading-none">Tidak berminat</span>
                                <span class="text-[10px] text-on-surface-variant uppercase tracking-tighter mt-1 block">Ditolak atau sedang tidak dalam cakupan</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-surface-container-low border-t border-outline-variant/10 flex gap-4 justify-end">
                <a href="{{ route('survey.index') }}" class="px-6 py-2 text-on-surface-variant font-bold text-sm hover:bg-surface-container-highest rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="bg-gradient-to-br from-primary to-primary-dim px-10 py-2 rounded-lg text-white font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Kirim Data
                </button>
            </div>
        </form>
    </div>
@endsection