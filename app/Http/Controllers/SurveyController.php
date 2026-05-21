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

        // Hitung Overview Stats secara global
        $statsQuery = SurveyData::query();

        // Terapkan filter Petugas jika diisi
        if ($request->filled('petugas')) {
            $query->where('id_pengguna', $request->petugas);
            $statsQuery->where('id_pengguna', $request->petugas);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_input', $request->bulan);
            $statsQuery->whereMonth('tanggal_input', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_input', $request->tahun);
            $statsQuery->whereYear('tanggal_input', $request->tahun);
        }

        if ($request->filled('tipe')) {
            $query->where('hasil_survey', $request->tipe);
            $statsQuery->where('hasil_survey', $request->tipe);
        }

        $totalSurvey = (clone $statsQuery)->count();
        $berminatCount = (clone $statsQuery)->where('hasil_survey', 'berminat')->count();
        $pikirCount = (clone $statsQuery)->where('hasil_survey', 'pikir-pikir')->count();
        $tidakBerminatCount = (clone $statsQuery)->where('hasil_survey', 'tidak berminat')->count();

        $limit = in_array($request->get('limit'), [5, 10, 20, 25]) ? (int) $request->get('limit') : 10;

        return view('survey.index', [
            'items' => $query->paginate($limit)->withQueryString(),
            'totalSurvey' => $totalSurvey,
            'berminatCount' => $berminatCount,
            'pikirCount' => $pikirCount,
            'tidakBerminatCount' => $tidakBerminatCount,
            'usersList' => Pengguna::orderBy('nama_lengkap')->get(),
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
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'kecamatan' => ['nullable', 'string', 'max:100'],
            'alamat_detail' => ['nullable', 'string'],
        ]);

        $validatedData['id_pengguna'] = $request->user()->id_pengguna;
        $validatedData['tanggal_input'] = now();

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

    public function trash(Request $request)
    {
        $query = SurveyData::onlyTrashed()->with('pengguna')->orderByDesc('id_survey');

        return view('survey.trash', [
            'items' => $query->paginate(10),
        ]);
    }

    public function restore(Request $request, $id)
    {
        $survey = SurveyData::onlyTrashed()->findOrFail($id);
        
        if (!Gate::allows('admin') && $survey->id_pengguna !== $request->user()->id_pengguna) {
            abort(403);
        }

        $survey->restore();
        
        Aktivitas::create([
            'nama_aktivitas' => 'Restore Survey',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Memulihkan data survey: ' . $survey->nama_responden,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        return redirect()->back()->with('status', 'Data survey berhasil dipulihkan.');
    }

    public function forceDelete(Request $request, $id)
    {
        $survey = SurveyData::onlyTrashed()->findOrFail($id);
        
        if (!Gate::allows('admin') && $survey->id_pengguna !== $request->user()->id_pengguna) {
            abort(403);
        }

        Aktivitas::create([
            'nama_aktivitas' => 'Hapus Permanen Survey',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus permanen data survey: ' . $survey->nama_responden,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        $survey->forceDelete();

        return redirect()->back()->with('status', 'Data survey dihapus permanen.');
    }

    public function print(Request $request)
    {
        $query = SurveyData::with('pengguna')->orderByDesc('id_survey');

        if ($request->filled('petugas')) {
            $query->where('id_pengguna', $request->petugas);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_input', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_input', $request->tahun);
        }

        if ($request->filled('tipe')) {
            $query->where('hasil_survey', $request->tipe);
        }

        $items = $query->get();

        $bulanNama = [
            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
            '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
        ];
        $filterBulan = $request->filled('bulan') ? ($bulanNama[$request->bulan] ?? null) : null;
        $filterTahun = $request->get('tahun');
        $filterTipe = $request->get('tipe');

        return view('survey.print', compact('items', 'filterBulan', 'filterTahun', 'filterTipe'));
    }
}