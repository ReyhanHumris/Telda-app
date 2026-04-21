<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\SurveyData;
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
        $data = $request->validate([
            'nama_responden' => ['required', 'string', 'max:100'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'kriteria' => ['required', 'string', 'max:100'],
            'hasil_survey' => ['required', 'in:berminat,pikir-pikir,tidak berminat'],
        ]);

        $data['id_pengguna'] = $request->user()->id_pengguna;

        SurveyData::create($data);

        return redirect()->route('survey.index')->with('status', 'Data survey berhasil disimpan.');
    }

    public function destroy(Request $request, SurveyData $survey)
    {
        $user = $request->user();
        $allowed = Gate::allows('admin') || $survey->id_pengguna === $user->id_pengguna;

        if (! $allowed) {
            abort(403);
        }

        $survey->delete();

        return redirect()->route('survey.index')->with('status', 'Data survey berhasil dihapus.');
    }
}

