@extends('layouts.admin')

@section('content')
    {{-- Header dengan Animasi Slide Down --}}
    <div class="mb-10 animate-fade-in-down">
        <h2 class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Ringkasan Dashboard</h2>
        <p class="text-on-surface-variant font-body mt-1">Kinerja operasional untuk wilayah Telda Labuan Bajo.</p>
    </div>

    <div class="grid grid-cols-12 gap-6 mb-10">
        {{-- Card Utama - Total Survei (Dibuat Lebih Berisi) --}}
        <div class="col-span-12 lg:col-span-5 bg-surface-container-lowest p-8 rounded-xl flex flex-col justify-between border-b-4 border-primary shadow-sm hover:shadow-md transition-all relative overflow-hidden group">
            {{-- Dekorasi Background --}}
            <span class="material-symbols-outlined absolute -right-4 -top-4 text-9xl text-primary/5 group-hover:text-primary/10 transition-colors">analytics</span>
            
            <div class="z-10">
                <span class="text-[11px] uppercase tracking-widest text-on-surface-variant font-semibold">Total Survei Aktif</span>
                <div class="flex items-baseline gap-2 mt-4">
                    <h3 class="text-6xl font-extrabold text-primary font-headline tabular-nums">{{ number_format($surveyTotal) }}</h3>
                    <span class="text-sm font-bold text-success flex items-center bg-success/10 px-2 py-0.5 rounded text-green-600">
                        <span class="material-symbols-outlined text-xs">trending_up</span> 12%
                    </span>
                </div>
                <p class="text-xs text-on-surface-variant mt-2">Data akumulasi dari {{ $aktivitasTotal }} aktivitas terakhir</p>
            </div>
            
            <div class="mt-10 grid grid-cols-2 gap-4 z-10 border-t border-outline-variant/10 pt-6">
                <div>
                    <p class="text-[10px] uppercase text-outline font-bold">Target Bulan Ini</p>
                    <p class="text-lg font-bold text-on-surface">2.000</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase text-outline font-bold">Pencapaian</p>
                    <p class="text-lg font-bold text-on-surface">{{ round(($surveyTotal/2000)*100) }}%</p>
                </div>
            </div>
        </div>

        {{-- Bento Stats (Grid Kanan - Dibuat Lebih Detail) --}}
        <div class="col-span-12 lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-all border border-transparent hover:border-primary/10 group">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-secondary-container text-on-secondary-container rounded-lg group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">database</span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-on-surface-variant">Data Indibiz</p>
                        <p class="text-2xl font-bold font-headline text-on-surface">{{ number_format($indibizTotal) }}</p>
                    </div>
                </div>
                <div class="w-full h-1.5 bg-surface-container-highest rounded-full overflow-hidden">
                    <div class="h-full bg-primary w-[75%]"></div>
                </div>
                <p class="text-[10px] text-on-surface-variant mt-2 italic">*Data tersinkronisasi otomatis</p>
            </div>

            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-all border border-transparent hover:border-error/10">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-error-container text-on-error-container rounded-lg">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-on-surface-variant">Aktivitas Sistem</p>
                        <p class="text-2xl font-bold font-headline text-on-surface">{{ number_format($aktivitasTotal) }}</p>
                    </div>
                </div>
                <div class="flex -space-x-2 mt-4 overflow-hidden">
                    <div class="h-6 w-6 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[8px] font-bold">A</div>
                    <div class="h-6 w-6 rounded-full border-2 border-white bg-blue-200 flex items-center justify-center text-[8px] font-bold">B</div>
                    <div class="h-6 w-6 rounded-full border-2 border-white bg-green-200 flex items-center justify-center text-[8px] font-bold">+5</div>
                </div>
            </div>

            {{-- Card Full Width di dalam Bento Grid --}}
            <div class="sm:col-span-2 bg-gradient-to-r from-[#185eb0] to-[#0051a1] p-6 rounded-xl text-white flex justify-between items-center relative overflow-hidden shadow-lg shadow-primary/20">
                <div class="z-10">
                    <h4 class="font-bold text-lg">Input Data Baru?</h4>
                    <p class="text-xs opacity-80 mt-1">Tambahkan hasil survey lapangan hari ini dengan cepat.</p>
                </div>
                <a href="{{ route('survey.create') }}" class="z-10 bg-white text-primary px-6 py-2 rounded-full font-bold text-sm hover:bg-opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_circle</span> Input Survey
                </a>
                <span class="material-symbols-outlined absolute right-[-10px] bottom-[-20px] text-8xl opacity-10 rotate-12">map</span>
            </div>
        </div>
    </div>

    {{-- BAGIAN TENGAH: Chart dan Aktivitas --}}
    <div class="grid grid-cols-12 gap-8 mb-10">
        {{-- Chart Section --}}
        <div class="col-span-12 xl:col-span-8">
            <div class="bg-surface-container-lowest rounded-xl p-8 h-full shadow-sm border border-outline-variant/10">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h4 class="text-lg font-bold font-headline text-on-surface">Tren Aktivitas</h4>
                        <p class="text-xs text-on-surface-variant">Perbandingan mingguan data survey</p>
                    </div>
                    <div class="flex bg-surface-container-low p-1 rounded-lg">
                        <button class="px-4 py-1.5 text-xs font-bold rounded-md bg-white shadow-sm text-primary transition-all">Mingguan</button>
                        <button class="px-4 py-1.5 text-xs font-bold text-on-surface-variant hover:text-primary transition-all">Bulanan</button>
                    </div>
                </div>
                <div id="dashChart" class="h-64"></div>
            </div>
        </div>

        {{-- Aktivitas Terbaru (Dibuat Lebih List-Like) --}}
        <div class="col-span-12 xl:col-span-4">
            <div class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10 shadow-sm h-full">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-lg font-bold font-headline text-on-surface">Aktivitas Terbaru</h4>
                    <span class="material-symbols-outlined text-on-surface-variant">more_vert</span>
                </div>
                <div class="space-y-6">
                    @forelse ($aktivitasTerbaru as $a)
                        <div class="flex gap-4 group cursor-default">
                            <div class="mt-1 w-2 h-2 rounded-full bg-primary ring-4 ring-primary/10 group-hover:ring-primary/30 transition-all shrink-0"></div>
                            <div class="border-b border-outline-variant/5 pb-2 w-full overflow-hidden">
                                <p class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors truncate">{{ $a->nama_aktivitas }}</p>
                                <p class="text-xs text-on-surface-variant mt-0.5">{{ $a->pengguna?->nama_lengkap ?? 'System' }}</p>
                                <p class="text-[10px] text-outline mt-1 font-medium italic">
                                    {{ optional($a->tanggal_aktivitas)->diffForHumans() ?? 'Baru saja' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl opacity-20 italic">history_toggle_off</span>
                            <p class="text-sm mt-2 font-medium">Belum ada data aktivitas.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: Peta Wilayah Labuan Bajo --}}
    <div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm group">
        <div class="p-6 border-b border-outline-variant/5 flex justify-between items-center bg-surface-container-low/30">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">distance</span>
                <div>
                    <h4 class="text-lg font-bold font-headline text-on-surface">Peta Operasional Labuan Bajo</h4>
                    <p class="text-xs text-on-surface-variant italic">Monitoring wilayah kerja Telkom Labuan Bajo</p>
                </div>
            </div>
            <button class="flex items-center gap-2 text-xs font-bold text-primary hover:underline">
                <span>Perbesar Peta</span>
                <span class="material-symbols-outlined text-sm">open_in_new</span>
            </button>
        </div>
        <div class="h-[450px] w-full bg-surface-container-highest relative">
            {{-- Google Maps Embed --}}
            <iframe 
                width="100%" 
                height="100%" 
                frameborder="0" 
                style="border:0; filter: contrast(1.1) brightness(1.02);" 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31548.8837330743!2d119.8665046!3d-8.494799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db46698650e6403%3A0x1030bfb510c4d40!2sLabuan%20Bajo%2C%20Komodo%2C%20West%20Manggarai%20Regency%2C%20East%20Nusa%20Tenggara!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                allowfullscreen>
            </iframe>
        </div>
    </div>

    <style>
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down { animation: fadeInDown 0.6s ease-out; }
    </style>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const options = {
            chart: { 
                type: 'bar', 
                height: 280, 
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            colors: ['#185eb0', '#49636f'],
            series: [
                { name: 'Indibiz', data: [{{ $indibizTotal }}, {{ max(1, floor($indibizTotal * 0.75)) }}, {{ max(1, floor($indibizTotal * 0.9)) }}] },
                { name: 'Survey', data: [{{ $surveyTotal }}, {{ max(1, floor($surveyTotal * 0.6)) }}, {{ max(1, floor($surveyTotal * 0.8)) }}] }
            ],
            xaxis: { 
                categories: ['Minggu Ini', 'Minggu Lalu', 'Target'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            plotOptions: { 
                bar: { borderRadius: 8, columnWidth: '45%' } 
            },
            grid: { borderColor: '#f1f1f1', strokeDashArray: 4 },
            legend: { position: 'top', horizontalAlign: 'right' },
            dataLabels: { enabled: false }
        };

        const chart = new ApexCharts(document.querySelector("#dashChart"), options);
        chart.render();
    });
</script>
@endpush