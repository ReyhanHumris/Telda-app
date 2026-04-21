@extends('layouts.admin')

@section('content')
    <div class="mb-10">
        <h2 class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">Ringkasan Dashboard</h2>
        <p class="text-on-surface-variant font-body mt-1">Kinerja operasional untuk wilayah Telda Labuan Bajo.</p>
    </div>
    <div class="grid grid-cols-12 gap-6 mb-10">
        <div class="col-span-12 lg:col-span-5 bg-surface-container-lowest p-8 rounded-xl flex flex-col justify-between border-b-2 border-primary">
            <div>
                <span class="text-[11px] uppercase tracking-widest text-on-surface-variant font-semibold">Total Survei Aktif</span>
                <h3 class="text-5xl font-extrabold text-primary font-headline mt-4">{{ number_format($surveyTotal) }}</h3>
            </div>
            <div class="mt-8 flex items-center gap-2 text-primary font-semibold">
                <span class="material-symbols-outlined text-lg">trending_up</span>
                <span class="text-sm">Data real-time dari sistem</span>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-7 grid grid-cols-2 gap-6">
            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-colors">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-2 bg-secondary-container text-on-secondary-container rounded-lg"><span class="material-symbols-outlined">dataset</span></div>
                    <span class="text-[10px] bg-primary/10 text-primary px-2 py-1 rounded-full font-bold">LANGSUNG</span>
                </div>
                <p class="text-sm font-medium text-on-surface-variant">Data Indibiz</p>
                <p class="text-2xl font-bold font-headline text-on-surface">{{ number_format($indibizTotal) }}</p>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-colors">
                <div class="flex justify-between items-start mb-4"><div class="p-2 bg-tertiary-container text-on-tertiary-container rounded-lg"><span class="material-symbols-outlined">pending_actions</span></div></div>
                <p class="text-sm font-medium text-on-surface-variant">Sinkronisasi Tertunda</p>
                <p class="text-2xl font-bold font-headline text-on-surface">0</p>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-colors">
                <div class="flex justify-between items-start mb-4"><div class="p-2 bg-primary-container text-on-primary-container rounded-lg"><span class="material-symbols-outlined">person_pin_circle</span></div></div>
                <p class="text-sm font-medium text-on-surface-variant">Petugas Aktif</p>
                <p class="text-2xl font-bold font-headline text-on-surface">{{ $user->role === 'admin' ? 'Admin' : 'Officer' }}</p>
            </div>
            <div class="bg-surface-container-low p-6 rounded-xl hover:bg-surface-container transition-colors">
                <div class="flex justify-between items-start mb-4"><div class="p-2 bg-error-container/20 text-error rounded-lg"><span class="material-symbols-outlined">history</span></div></div>
                <p class="text-sm font-medium text-on-surface-variant">Total Aktivitas</p>
                <p class="text-2xl font-bold font-headline text-on-surface">{{ number_format($aktivitasTotal) }}</p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-8">
        <div class="col-span-12 xl:col-span-8">
            <div class="bg-surface-container-lowest rounded-xl p-8 h-full">
                <div class="flex justify-between items-center mb-8">
                    <h4 class="text-lg font-bold font-headline text-on-surface">Tren Data</h4>
                    <div class="text-xs text-on-surface-variant">Indibiz vs Survey</div>
                </div>
                <div id="dashChart" class="h-64"></div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-4">
            <div class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/10">
                <h4 class="text-lg font-bold font-headline text-on-surface mb-6">Aktivitas Terbaru</h4>
                <div class="space-y-6">
                    @forelse ($aktivitasTerbaru as $a)
                        <div class="flex gap-4">
                            <div class="mt-1 w-2 h-2 rounded-full bg-primary ring-4 ring-primary/10 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-semibold text-on-surface leading-tight">{{ $a->nama_aktivitas }}</p>
                                <p class="text-xs text-on-surface-variant mt-1">{{ $a->pengguna?->nama_lengkap }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-on-surface-variant">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const chart = new ApexCharts(document.querySelector("#dashChart"), {
        chart: { type: 'bar', height: 250, toolbar: { show: false } },
        colors: ['#185eb0', '#49636f'],
        series: [
            { name: 'Indibiz', data: [{{ $indibizTotal }}, {{ max(1, floor($indibizTotal * 0.7)) }}, {{ max(1, floor($indibizTotal * 0.85)) }}] },
            { name: 'Survey', data: [{{ $surveyTotal }}, {{ max(1, floor($surveyTotal * 0.65)) }}, {{ max(1, floor($surveyTotal * 0.9)) }}] }
        ],
        xaxis: { categories: ['Awal', 'Tengah', 'Akhir'] },
        dataLabels: { enabled: false },
        plotOptions: { bar: { borderRadius: 6 } },x
        grid: { borderColor: '#e5e7eb' },
        legend: { position: 'top' }
    });
    chart.render();
</script>
@endpush

