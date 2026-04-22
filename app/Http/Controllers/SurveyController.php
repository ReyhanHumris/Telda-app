<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\SurveyData;
use App\Models\Aktivitas; // Tambahkan ini agar aktivitas tercatat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $query = SurveyData::with('pengguna')->orderByDesc('id_survey');

        if ($request->user()->role !== Pengguna::ROLE_ADMIN) {
            $query->where('id_pengguna', $request->user()->id_pengguna);
        }

        return view('survey.index', [
            'items' => $query->get(),
        ]);
    }

    public function create()
    {
        return view('survey.create');
    }

    public function store(Request $request)
    {
        // Validasi sesuai input di create.blade.php
        $validatedData = $request->validate([
            'nama_responden' => ['required', 'string', 'max:100'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'kriteria' => ['required', 'string', 'max:100'],
            'hasil_survey' => ['required', 'in:berminat,pikir-pikir,tidak berminat'],
        ]);

        $validatedData['id_pengguna'] = $request->user()->id_pengguna;

        // 1. Simpan data Survey
        $survey = SurveyData::create($validatedData);

        // 2. Otomatis tercatat di Dashboard Aktivitas
        Aktivitas::create([
            'nama_aktivitas' => 'Input Survey Baru',
            'tanggal_aktivitas' => now(), 
            'keterangan' => 'Menambahkan survey responden: ' . $survey->nama_responden . ' (' . $survey->hasil_survey . ')',
            'id_pengguna' => $request->user()->id_pengguna, 
        ]);

        return redirect()->route('survey.index')->with('status', 'Data survey berhasil disimpan.');
    }

    public function destroy(Request $request, SurveyData $survey)
    {
        $user = $request->user();
        
        // Cek izin hapus (Admin atau pemilik data)
        $allowed = Gate::allows('admin') || $survey->id_pengguna === $user->id_pengguna;

        if (! $allowed) {
            abort(403);
        }

        // Catat log sebelum data benar-benar dihapus agar nama_responden masih terbaca
        Aktivitas::create([
            'nama_aktivitas' => 'Menghapus Data Survey',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus data survey atas nama: ' . $survey->nama_responden,
            'id_pengguna' => $user->id_pengguna,
        ]);

        $survey->delete();

        return redirect()->route('survey.index')->with('status', 'Data survey berhasil dihapus.');
    }
}