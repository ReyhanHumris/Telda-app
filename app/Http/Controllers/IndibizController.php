<?php

namespace App\Http\Controllers;

use App\Models\IndibizData;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IndibizController extends Controller
{
    public function index(Request $request)
    {
        $query = IndibizData::with('pengguna')->orderByDesc('id_indibiz');

        if ($request->user()->role !== Pengguna::ROLE_ADMIN) {
            $query->where('id_pengguna', $request->user()->id_pengguna);
        }

        return view('indibiz.index', [
            'items' => $query->get(),
        ]);
    }

    public function create()
    {
        return view('indibiz.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:100'],
            'alamat_perusahaan' => ['required', 'string'],
            'jenis_layanan' => ['required', 'string', 'max:50'],
            'status_langganan' => ['required', 'in:aktif,nonaktif'],
        ]);

        $data['id_pengguna'] = $request->user()->id_pengguna;

        IndibizData::create($data);

        return redirect()->route('indibiz.index')->with('status', 'Data Indibiz berhasil disimpan.');
    }

    public function destroy(Request $request, IndibizData $indibiz)
    {
        $user = $request->user();
        $allowed = Gate::allows('admin') || $indibiz->id_pengguna === $user->id_pengguna;

        if (! $allowed) {
            abort(403);
        }

        $indibiz->delete();

        return redirect()->route('indibiz.index')->with('status', 'Data Indibiz berhasil dihapus.');
    }
}

