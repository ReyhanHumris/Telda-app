@extends('layouts.admin')

@push('head')
    <style>
        #dashboardMap { z-index: 1; min-height: 420px; }
    </style>
@endpush

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

    {{-- Leaderboard Row --}}
    <div class="bg-surface-container-lowest rounded-xl p-6 border border-outline-variant/10 shadow-sm mb-8 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h4 class="text-lg font-bold font-headline flex items-center gap-2">
                    <span class="material-symbols-outlined text-amber-500 fill-icon">emoji_events</span>
                    Klasemen Performa Officer (Leaderboard)
                </h4>
                <p class="text-xs text-on-surface-variant">Peringkat kontribusi berdasarkan akumulasi survei dan penutupan layanan aktif.</p>
            </div>
            <div class="text-[11px] font-bold text-on-surface-variant bg-surface-container-low px-3 py-1.5 rounded-lg border border-outline-variant/10 self-start sm:self-center">
                ⭐ Skor = (Survei × 10) + (Indibiz Aktif × 50)
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant/10 text-xs font-bold text-on-surface-variant uppercase tracking-wider">
                        <th class="py-3 px-4 w-20 text-center">Peringkat</th>
                        <th class="py-3 px-4">Nama Officer</th>
                        <th class="py-3 px-4 text-center">Total Survei</th>
                        <th class="py-3 px-4 text-center">Indibiz Aktif</th>
                        <th class="py-3 px-4 text-center">Rasio Konversi</th>
                        <th class="py-3 px-4 text-right">Skor Performa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/5 text-sm">
                    @forelse($leaderboard as $index => $item)
                        @php
                            $rowClass = '';
                            $badge = '';
                            $rank = $index + 1;
                            
                            if ($rank === 1) {
                                $rowClass = 'bg-amber-500/5 font-semibold';
                                $badge = '🥇';
                            } elseif ($rank === 2) {
                                $rowClass = 'bg-slate-400/5';
                                $badge = '🥈';
                            } elseif ($rank === 3) {
                                $rowClass = 'bg-amber-700/5';
                                $badge = '🥉';
                            }
                            
                            // Sorot pengguna saat ini yang sedang login
                            if ($item['pengguna']->id_pengguna === auth()->user()->id_pengguna) {
                                $rowClass .= ' ring-2 ring-primary/20 bg-primary/5';
                            }
                        @endphp
                        <tr class="hover:bg-surface-container-low transition-colors {{ $rowClass }}">
                            <td class="py-3.5 px-4 text-center font-extrabold text-base">
                                @if($badge)
                                    <span class="text-xl inline-block drop-shadow-sm">{{ $badge }}</span>
                                @else
                                    <span class="text-on-surface-variant text-sm">{{ $rank }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    @if ($item['pengguna']->foto)
                                        <img src="{{ $item['pengguna']->foto_url }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border border-outline-variant/20">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-primary-container text-primary font-bold flex items-center justify-center text-xs">
                                            {{ $item['pengguna']->inisial() }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold text-on-surface">{{ $item['pengguna']->nama_lengkap }}</span>
                                            @if($item['pengguna']->id_pengguna === auth()->user()->id_pengguna)
                                                <span class="text-[9px] bg-primary text-on-primary px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Anda</span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-on-surface-variant uppercase tracking-wider">{{ $item['pengguna']->role }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold tabular-nums">{{ $item['total_surveys'] }}</td>
                            <td class="py-3.5 px-4 text-center font-semibold tabular-nums text-emerald-600">{{ $item['total_indibiz_aktif'] }}</td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-primary-container text-primary">
                                    {{ $item['conversion_rate'] }}%
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <span class="font-extrabold text-base text-primary tabular-nums">{{ number_format($item['score']) }}</span>
                                <span class="text-[10px] text-on-surface-variant"> pts</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-on-surface-variant text-sm">Belum ada data kontribusi dari officer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
    <div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm mb-6">
        <div class="p-5 border-b border-outline-variant/10 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">distance</span>
                <h4 class="font-bold font-headline">Peta Sebaran Koordinat Labuan Bajo</h4>
            </div>
            <div class="flex items-center gap-4 text-xs font-semibold text-on-surface-variant">
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span> Berminat / Aktif</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span> Pikir-pikir</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-slate-400 inline-block"></span> Tidak Berminat / Nonaktif</span>
            </div>
        </div>
        <div class="h-[420px] w-full">
            <div id="dashboardMap" class="w-full h-full border-0"></div>
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
    const mapLocations = @json($mapLocations);

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

        // Initialize Google Maps
        window.initDashboardMap = function() {
            const defaultLat = -8.4908;
            const defaultLng = 119.8824;
            const dashboardMap = new google.maps.Map(document.getElementById('dashboardMap'), {
                zoom: 13,
                center: { lat: defaultLat, lng: defaultLng },
                mapTypeControl: true,
                streetViewControl: false,
                fullscreenControl: true
            });

            const bounds = new google.maps.LatLngBounds();
            let hasMarkers = false;

            // Render markers for all coordinate locations
            mapLocations.forEach(loc => {
                let markerColor = '#94a3b8'; // grey
                if (loc.status === 'berminat' || loc.status === 'aktif') {
                    markerColor = '#10b981'; // emerald
                } else if (loc.status === 'pikir-pikir') {
                    markerColor = '#f59e0b'; // amber
                } else if (loc.status === 'tidak berminat' || loc.status === 'nonaktif') {
                    markerColor = '#ef4444'; // red
                }

                // Beautiful custom colored pointer pin using SVG paths
                const markerIcon = {
                    path: 'M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z',
                    fillColor: markerColor,
                    fillOpacity: 1.0,
                    strokeWeight: 2,
                    strokeColor: '#FFFFFF',
                    scale: 1.5,
                    anchor: new google.maps.Point(12, 21),
                };

                const marker = new google.maps.Marker({
                    position: { lat: loc.lat, lng: loc.lng },
                    map: dashboardMap,
                    title: loc.title,
                    icon: markerIcon
                });

                const popupContent = `
                    <div style="font-family: 'Inter', sans-serif; padding: 4px; width: 180px;">
                        <span style="font-size: 9px; font-weight: bold; text-transform: uppercase; color: #fff; background-color: ${loc.type === 'survey' ? '#185eb0' : '#49636f'}; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-bottom: 6px;">
                            ${loc.type}
                        </span>
                        <h5 style="margin: 0 0 4px 0; font-size: 13px; font-weight: 700; color: #2b3437; line-height: 1.3;">${loc.title}</h5>
                        <p style="margin: 0 0 8px 0; font-size: 11px; color: #586064;">${loc.subtitle}</p>
                        <div style="border-top: 1px solid #eaeff1; padding-top: 6px; display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 9px; color: #94a3b8; font-weight: bold; text-transform: uppercase;">Status</span>
                            <span style="font-size: 10px; font-weight: bold; color: ${markerColor}; text-transform: capitalize;">${loc.status}</span>
                        </div>
                    </div>
                `;

                const infoWindow = new google.maps.InfoWindow({
                    content: popupContent
                });

                marker.addListener('click', function() {
                    infoWindow.open(dashboardMap, marker);
                });

                bounds.extend(marker.getPosition());
                hasMarkers = true;
            });

            // Fit map bounds if markers are present
            if (hasMarkers) {
                dashboardMap.fitBounds(bounds);
            }
        };
    });
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY', '') }}&callback=initDashboardMap" async defer></script>
@endpush
