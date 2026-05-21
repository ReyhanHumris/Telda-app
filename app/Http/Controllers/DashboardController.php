<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\IndibizData;
use App\Models\Pengguna;
use App\Models\SurveyData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $isAdmin = $user->role === Pengguna::ROLE_ADMIN;

        // Agar data selalu sama (global) baik login sebagai Officer maupun Admin
        $indibizQuery = IndibizData::query();
        $indibizTotal = (clone $indibizQuery)->count();
        $indibizAktif = (clone $indibizQuery)->where('status_langganan', 'aktif')->count();

        $surveyQuery = SurveyData::query();
        $surveyTotal = (clone $surveyQuery)->count();
        $surveyBreakdown = (clone $surveyQuery)
            ->selectRaw('hasil_survey, count(*) as count')
            ->groupBy('hasil_survey')
            ->pluck('count', 'hasil_survey');

        $surveyTerbaru = (clone $surveyQuery)->latest('id_survey')->limit(4)->get();

        // Aktivitas selalu global untuk pemantauan menyeluruh
        $aktivitasTotal = Aktivitas::count();

        $aktivitasTerbaru = Aktivitas::with('pengguna')
            ->latest('id_aktivitas')
            ->limit(4)
            ->get();

        // Sistem Leaderboard: dihitung secara global untuk memantau performansi seluruh officer
        $leaderboard = Pengguna::withCount([
            'surveys',
            'surveys as surveys_berminat_count' => function ($query) {
                $query->where('hasil_survey', 'berminat');
            },
            'indibizData as indibiz_aktif_count' => function ($query) {
                $query->where('status_langganan', 'aktif');
            }
        ])->get()->map(function ($pengguna) {
            $totalSurveys = $pengguna->surveys_count;
            $totalIndibizAktif = $pengguna->indibiz_aktif_count;
            $surveysBerminat = $pengguna->surveys_berminat_count;

            $conversionRate = $totalSurveys > 0 ? round(($surveysBerminat / $totalSurveys) * 100, 1) : 0;
            // Perhitungan Skor Kinerja: 10 Poin per Survey, 50 Poin per Indibiz Aktif
            $performanceScore = ($totalSurveys * 10) + ($totalIndibizAktif * 50);

            return [
                'pengguna' => $pengguna,
                'total_surveys' => $totalSurveys,
                'total_indibiz_aktif' => $totalIndibizAktif,
                'conversion_rate' => $conversionRate,
                'score' => $performanceScore
            ];
        })->sortByDesc('score')->values();

        $targetBulan = 100;
        $achievementPercent = $targetBulan > 0 ? min(100, round(($surveyTotal / $targetBulan) * 100)) : 0;

        // Trend Input Data: Weekly (Senin-Minggu minggu ini)
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        
        $surveyWeeklyData = (clone $surveyQuery)->whereBetween('tanggal_input', [$startOfWeek, $endOfWeek])->get();
        $indibizWeeklyData = (clone $indibizQuery)->whereBetween('tanggal_input', [$startOfWeek, $endOfWeek])->get();

        $weeklySurveyArr = array_fill(0, 7, 0);
        $weeklyIndibizArr = array_fill(0, 7, 0);

        foreach ($surveyWeeklyData as $item) {
            $dayIndex = \Carbon\Carbon::parse($item->tanggal_input)->dayOfWeekIso - 1; // 1 (Mon) - 7 (Sun) => 0 - 6
            $weeklySurveyArr[$dayIndex]++;
        }
        foreach ($indibizWeeklyData as $item) {
            $dayIndex = \Carbon\Carbon::parse($item->tanggal_input)->dayOfWeekIso - 1;
            $weeklyIndibizArr[$dayIndex]++;
        }
        
        $chartWeekly = [
            'labels' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            'survey' => $weeklySurveyArr,
            'indibiz' => $weeklyIndibizArr,
        ];

        // Trend Input Data: Monthly (Minggu 1-4 bulan ini)
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $surveyMonthlyData = (clone $surveyQuery)->whereBetween('tanggal_input', [$startOfMonth, $endOfMonth])->get();
        $indibizMonthlyData = (clone $indibizQuery)->whereBetween('tanggal_input', [$startOfMonth, $endOfMonth])->get();

        $monthlySurveyArr = array_fill(0, 4, 0);
        $monthlyIndibizArr = array_fill(0, 4, 0);

        foreach ($surveyMonthlyData as $item) {
            $day = \Carbon\Carbon::parse($item->tanggal_input)->day;
            $weekIndex = min(3, floor(($day - 1) / 7)); // 0, 1, 2, 3
            $monthlySurveyArr[$weekIndex]++;
        }
        foreach ($indibizMonthlyData as $item) {
            $day = \Carbon\Carbon::parse($item->tanggal_input)->day;
            $weekIndex = min(3, floor(($day - 1) / 7));
            $monthlyIndibizArr[$weekIndex]++;
        }

        $chartMonthly = [
            'labels' => ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            'survey' => $monthlySurveyArr,
            'indibiz' => $monthlyIndibizArr,
        ];

        // Fetch coordinates for maps pin
        $mapLocations = [];
        $surveysWithLoc = (clone $surveyQuery)->whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($surveysWithLoc as $s) {
            $subtitle = $s->kriteria;
            if ($s->kecamatan) {
                $subtitle .= ' · Kec. ' . $s->kecamatan;
            }
            if ($s->alamat_detail) {
                $subtitle .= ' (' . $s->alamat_detail . ')';
            }

            $mapLocations[] = [
                'type' => 'survey',
                'title' => $s->nama_responden,
                'subtitle' => $subtitle,
                'status' => $s->hasil_survey,
                'lat' => (double) $s->latitude,
                'lng' => (double) $s->longitude,
            ];
        }
        $indibizWithLoc = (clone $indibizQuery)->whereNotNull('latitude')->whereNotNull('longitude')->get();
        foreach ($indibizWithLoc as $i) {
            $mapLocations[] = [
                'type' => 'indibiz',
                'title' => $i->nama_perusahaan,
                'subtitle' => $i->jenis_layanan,
                'status' => $i->status_langganan,
                'lat' => (double) $i->latitude,
                'lng' => (double) $i->longitude,
            ];
        }

        return view('dashboard', [
            'user' => $user,
            'isAdmin' => $isAdmin,
            'indibizTotal' => $indibizTotal,
            'indibizAktif' => $indibizAktif,
            'surveyTotal' => $surveyTotal,
            'surveyBreakdown' => $surveyBreakdown,
            'surveyTerbaru' => $surveyTerbaru,
            'aktivitasTotal' => $aktivitasTotal,
            'aktivitasTerbaru' => $aktivitasTerbaru,
            'targetBulan' => $targetBulan,
            'achievementPercent' => $achievementPercent,
            'chartWeekly' => $chartWeekly,
            'chartMonthly' => $chartMonthly,
            'mapLocations' => $mapLocations,
            'leaderboard' => $leaderboard,
        ]);
    }
}

