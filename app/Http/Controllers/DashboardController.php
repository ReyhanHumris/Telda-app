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

        $indibizTotal = $isAdmin
            ? IndibizData::count()
            : IndibizData::where('id_pengguna', $user->id_pengguna)->count();

        $surveyTotal = $isAdmin
            ? SurveyData::count()
            : SurveyData::where('id_pengguna', $user->id_pengguna)->count();

        $aktivitasTotal = $isAdmin
            ? Aktivitas::count()
            : Aktivitas::where('id_pengguna', $user->id_pengguna)->count();

        $aktivitasTerbaru = Aktivitas::with('pengguna')
            ->latest('id_aktivitas')
            ->limit(4)
            ->get();

        return view('dashboard', [
            'user' => $user,
            'indibizTotal' => $indibizTotal,
            'surveyTotal' => $surveyTotal,
            'aktivitasTotal' => $aktivitasTotal,
            'aktivitasTerbaru' => $aktivitasTerbaru,
        ]);
    }
}

