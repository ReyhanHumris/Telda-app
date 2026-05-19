@extends('layouts.admin')

@php
    $greeting = match (true) {
        now()->hour < 11 => 'Selamat pagi',
        now()->hour < 15 => 'Selamat siang',
        now()->hour < 18 => 'Selamat sore',
        default => 'Selamat malam',
    };
    $breakdownLabels = $surveyBreakdown->keys()->values();
    $breakdownValues = $surveyBreakdown->values();
@endphp

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row lg:items-end justify-between gap-4 animate-fade-in">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-primary mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            <h2 class="text-3xl font-extrabold text-on-surface font-headline tracking-tight">{{ $greeting }}, {{ $user->nama_lengkap }}!</h2>
            <p class="text-on-surface-variant font-body mt-1">Ringkasan operasional Telda Labuan Bajo — data diperbarui secara real-time.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('survey.create') }}" class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform">
                <span class="material-symbols-outlined text-sm">add_task</span> Input Survey
            </a>
            <a href="{{ route('indibiz.create') }}" class="flex items-center gap-2 px-4 py-2 bg-surface-container-high text-on-surface rounded-xl text-sm font-bold border border-outline-variant/30 hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-sm">database</span> Input Indibiz
            </a>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-12 gap-6 mb-8">
        <a href="{{ route('survey.index') }}" class="col-span-12 sm:col-span-6 xl:col-span-3 stat-card group bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md hover:border-primary/30 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2.5 rounded-lg bg-primary-container text-primary group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">fact_check</span>
                </div>
                <span class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full">Survey</span>
            </div>
            <p class="text-[11px] uppercase tracking-widest text-on-surface-variant mt-4 font-semibold">Total Survey</p>
            <p class="text-4xl font-extrabold text-primary font-headline tabular-nums counter" data-target="{{ $surveyTotal }}">0</p>
        </a>

        <a href="{{ route('indibiz.index') }}" class="col-span-12 sm:col-span-6 xl:col-span-3 stat-card group bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md hover:border-secondary/30 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2.5 rounded-lg bg-secondary-container text-on-secondary-container group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined">database</span>
                </div>
                <span class="text-[10px] font-bold text-secondary">{{ $indibizAktif }} aktif</span>
            </div>
            <p class="text-[11px] uppercase tracking-widest text-on-surface-variant mt-4 font-semibold">Data Indibiz</p>
            <p class="text-4xl font-extrabold text-on-surface font-headline tabular-nums counter" data-target="{{ $indibizTotal }}">0</p>
        </a>

        @if ($isAdmin)
            <a href="{{ route('aktivitas.index') }}" class="col-span-12 sm:col-span-6 xl:col-span-3 stat-card group bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start">
                    <div class="p-2.5 rounded-lg bg-error-container text-error">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                </div>
                <p class="text-[11px] uppercase tracking-widest text-on-surface-variant mt-4 font-semibold">Log Aktivitas</p>
                <p class="text-4xl font-extrabold text-on-surface font-headline tabular-nums counter" data-target="{{ $aktivitasTotal }}">0</p>
            </a>
        @endif

        <div class="col-span-12 sm:col-span-6 xl:col-span-3 bg-gradient-to-br from-primary to-primary-dim p-6 rounded-xl text-white shadow-lg shadow-primary/25 relative overflow-hidden">
            <span class="material-symbols-outlined absolute -right-2 -bottom-2 text-7xl opacity-10">flag</span>
            <p class="text-[11px] uppercase tracking-widest opacity-80 font-semibold">Target Bulan Ini</p>
            <p class="text-3xl font-extrabold font-headline mt-1 counter" data-target="{{ $achievementPercent }}">0</p>
            <p class="text-xs opacity-80 mt-1">% dari {{ number_format($targetBulan) }} survey</p>
            <div class="mt-4 h-2 bg-white/20 rounded-full overflow-hidden">
                <div class="h-full bg-white rounded-full transition-all duration-1000" id="targetBar" style="width: 0%"></div>
            </div>
        </div>
    </div>

    {{-- Charts row --}}
    <div class="grid grid-cols-12 gap-6 mb-8">
        <div class="col-span-12 xl:col-span-8 bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h4 class="text-lg font-bold font-headline">Tren Input Data</h4>
                    <p class="text-xs text-on-surface-variant">Perbandingan Survey vs Indibiz</p>
                </div>
                <div class="flex bg-surface-container-low p-1 rounded-lg" id="chartPeriodToggle">
                    <button type="button" data-period="week" class="chart-period-btn px-4 py-1.5 text-xs font-bold rounded-md bg-white shadow-sm text-primary transition-all">Mingguan</button>
                    <button type="button" data-period="month" class="chart-period-btn px-4 py-1.5 text-xs font-bold text-on-surface-variant hover:text-primary transition-all">Bulanan</button>
                </div>
            </div>
            <div id="dashTrendChart" class="h-72"></div>
        </div>

        <div class="col-span-12 xl:col-span-4 bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
            <h4 class="text-lg font-bold font-headline mb-1">Hasil Survey</h4>
            <p class="text-xs text-on-surface-variant mb-4">Distribusi responden</p>
            <div id="dashDonutChart" class="h-52"></div>
            @if ($surveyBreakdown->isEmpty())
                <p class="text-center text-sm text-on-surface-variant py-8">Belum ada data survey.</p>
            @endif
        </div>
    </div>

    {{-- Lists row --}}
    <div class="grid grid-cols-12 gap-6 mb-8">
        <div class="col-span-12 lg:col-span-6 bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-bold font-headline">Survey Terbaru</h4>
                <a href="{{ route('survey.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat semua</a>
            </div>
            <div class="space-y-3">
                @forelse ($surveyTerbaru as $s)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-primary text-xs font-bold shrink-0">
                            {{ strtoupper(substr($s->nama_responden, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate group-hover:text-primary transition-colors">{{ $s->nama_responden }}</p>
                            <p class="text-xs text-on-surface-variant">{{ optional($s->tanggal_input)->diffForHumans() }}</p>
                        </div>
                        <span class="text-[10px] font-bold uppercase px-2 py-1 rounded-full bg-primary-container text-primary shrink-0">{{ $s->hasil_survey }}</span>
                    </div>
                @empty
                    <p class="text-sm text-on-surface-variant text-center py-6">Belum ada survey.</p>
                @endforelse
            </div>
        </div>

        <div class="col-span-12 lg:col-span-6 bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-lg font-bold font-headline">Aktivitas Terbaru</h4>
                @if ($isAdmin)
                    <a href="{{ route('aktivitas.index') }}" class="text-xs font-bold text-primary hover:underline">Lihat semua</a>
                @endif
            </div>
            <div class="space-y-4">
                @forelse ($aktivitasTerbaru as $a)
                    <div class="flex gap-3 group">
                        <div class="w-2 h-2 mt-2 rounded-full bg-primary ring-4 ring-primary/10 group-hover:ring-primary/30 transition-all shrink-0"></div>
                        <div class="flex-1 border-b border-outline-variant/10 pb-3">
                            <p class="text-sm font-semibold group-hover:text-primary transition-colors">{{ $a->nama_aktivitas }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $a->pengguna?->nama_lengkap ?? 'Sistem' }} · {{ optional($a->tanggal_aktivitas)->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-on-surface-variant text-center py-6">Belum ada aktivitas.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Map --}}
    <div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm">
        <div class="p-5 border-b border-outline-variant/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">distance</span>
                <h4 class="font-bold font-headline">Peta Operasional Labuan Bajo</h4>
            </div>
            <button type="button" id="btnExpandMap" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                Perbesar Peta <span class="material-symbols-outlined text-sm">open_in_new</span>
            </button>
        </div>
        <div class="h-[380px] w-full">
            <iframe class="w-full h-full border-0" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31548.8837330743!2d119.8665046!3d-8.494799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db46698650e6403%3A0x1030bfb510c4d40!2sLabuan%20Bajo!5e0!3m2!1sen!2sid"></iframe>
        </div>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .stat-card { cursor: pointer; }
    </style>
@endsection

@push('scripts')
<script>
    const chartData = {
        week: @json($chartWeekly),
        month: @json($chartMonthly),
    };
    const breakdownLabels = @json($breakdownLabels);
    const breakdownValues = @json($breakdownValues);
    const achievementPercent = {{ $achievementPercent }};

    document.addEventListener('DOMContentLoaded', function () {
        // Counter animation
        document.querySelectorAll('.counter').forEach((el) => {
            const target = parseInt(el.dataset.target, 10) || 0;
            const duration = 1200;
            const start = performance.now();
            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(target * eased).toLocaleString('id-ID');
                if (progress < 1) requestAnimationFrame(tick);
                else el.textContent = target.toLocaleString('id-ID');
            };
            requestAnimationFrame(tick);
        });

        const targetBar = document.getElementById('targetBar');
        if (targetBar) {
            setTimeout(() => { targetBar.style.width = achievementPercent + '%'; }, 300);
        }

        // Trend chart
        let currentPeriod = 'week';
        let trendChart = null;

        const renderTrend = (period) => {
            const data = chartData[period];
            const options = {
                chart: { type: 'area', height: 288, toolbar: { show: false }, fontFamily: 'Inter, sans-serif', animations: { enabled: true, speed: 600 } },
                colors: ['#185eb0', '#49636f'],
                series: [
                    { name: 'Survey', data: data.survey },
                    { name: 'Indibiz', data: data.indibiz },
                ],
                xaxis: { categories: data.labels, axisBorder: { show: false }, axisTicks: { show: false } },
                stroke: { curve: 'smooth', width: 2 },
                fill: { type: 'gradient', gradient: { opacityFrom: 0.35, opacityTo: 0.05 } },
                dataLabels: { enabled: false },
                grid: { borderColor: '#eaeff1', strokeDashArray: 4 },
                legend: { position: 'top', horizontalAlign: 'right' },
                tooltip: { theme: 'light' },
            };
            if (trendChart) {
                trendChart.updateOptions(options);
            } else {
                trendChart = new ApexCharts(document.querySelector('#dashTrendChart'), options);
                trendChart.render();
            }
        };

        renderTrend('week');

        document.querySelectorAll('.chart-period-btn').forEach((btn) => {
            btn.addEventListener('click', function () {
                const period = btn.dataset.period;
                if (period === currentPeriod) return;
                currentPeriod = period;
                document.querySelectorAll('.chart-period-btn').forEach((b) => {
                    b.classList.remove('bg-white', 'shadow-sm', 'text-primary');
                    b.classList.add('text-on-surface-variant');
                });
                btn.classList.add('bg-white', 'shadow-sm', 'text-primary');
                btn.classList.remove('text-on-surface-variant');
                renderTrend(period);
            });
        });

        // Donut chart
        if (breakdownValues.length && document.querySelector('#dashDonutChart')) {
            new ApexCharts(document.querySelector('#dashDonutChart'), {
                chart: { type: 'donut', height: 220, fontFamily: 'Inter, sans-serif' },
                labels: breakdownLabels,
                series: breakdownValues,
                colors: ['#185eb0', '#49636f', '#9f403d', '#5d5c78'],
                legend: { position: 'bottom', fontSize: '11px' },
                plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total' } } } } },
                dataLabels: { enabled: false },
            }).render();
        }

        // Expand map
        document.getElementById('btnExpandMap')?.addEventListener('click', () => {
            Swal.fire({
                title: 'Labuan Bajo',
                html: '<iframe class="w-full h-80 rounded-lg border-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31548.8837330743!2d119.8665046!3d-8.494799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db46698650e6403%3A0x1030bfb510c4d40!2sLabuan%20Bajo!5e0!3m2!1sen!2sid"></iframe>',
                width: 800,
                showConfirmButton: true,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#185eb0',
            });
        });
    });
</script>
@endpush
