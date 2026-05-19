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

        $indibizQuery = $isAdmin ? IndibizData::query() : IndibizData::where('id_pengguna', $user->id_pengguna);
        $indibizTotal = (clone $indibizQuery)->count();
        $indibizAktif = (clone $indibizQuery)->where('status_langganan', 'aktif')->count();

        $surveyQuery = $isAdmin ? SurveyData::query() : SurveyData::where('id_pengguna', $user->id_pengguna);
        $surveyTotal = (clone $surveyQuery)->count();
        $surveyBreakdown = (clone $surveyQuery)
            ->selectRaw('hasil_survey, count(*) as count')
            ->groupBy('hasil_survey')
            ->pluck('count', 'hasil_survey');

        $surveyTerbaru = (clone $surveyQuery)->latest('id_survey')->limit(4)->get();

        $aktivitasTotal = $isAdmin
            ? Aktivitas::count()
            : Aktivitas::where('id_pengguna', $user->id_pengguna)->count();

        $aktivitasTerbaru = Aktivitas::with('pengguna')
            ->latest('id_aktivitas')
            ->limit(4)
            ->get();

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
        ]);
    }
}

