<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function index()
    {
        return view('aktivitas.index', [
            'items' => Aktivitas::with('pengguna')
                ->orderByDesc('id_aktivitas')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('aktivitas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aktivitas' => ['required', 'string', 'max:100'],
            'tanggal_aktivitas' => ['required', 'date'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $data['id_pengguna'] = $request->user()->id_pengguna;

        Aktivitas::create($data);

        return redirect()->route('aktivitas.index')->with('status', 'Aktivitas berhasil disimpan.');
    }

    public function destroy(Aktivitas $aktivitas)
    {
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')->with('status', 'Aktivitas berhasil dihapus.');
    }
}

