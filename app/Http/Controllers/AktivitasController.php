<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        $limit = in_array($request->get('limit'), [5, 10, 20, 25]) ? (int) $request->get('limit') : 10;

        return view('aktivitas.index', [
            'items' => Aktivitas::with('pengguna')
                ->orderByDesc('id_aktivitas')
                ->paginate($limit)
                ->withQueryString(),
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
            'tanggal_aktivitas' => now(),
            'keterangan' => ['nullable', 'string'],
        ]);

        $data['id_pengguna'] = $request->user()->id_pengguna;

        Aktivitas::create($data);

        return redirect()->route('aktivitas.index')->with('status', 'Aktivitas berhasil disimpan.');
    }

    public function destroy(Aktivitas $aktivitas)
    {
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')->with('status', 'Aktivitas dipindahkan ke tempat sampah.');
    }

    public function trash()
    {
        return view('aktivitas.trash', [
            'items' => Aktivitas::onlyTrashed()
                ->with('pengguna')
                ->orderByDesc('id_aktivitas')
                ->paginate(10),
        ]);
    }

    public function restore(Request $request, $id)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $aktivitas = Aktivitas::onlyTrashed()->findOrFail($id);
        $aktivitas->restore();

        Aktivitas::create([
            'nama_aktivitas' => 'Restore Log Aktivitas',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Memulihkan log: ' . $aktivitas->nama_aktivitas,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        return redirect()->route('aktivitas.trash')->with('status', 'Aktivitas berhasil dipulihkan.');
    }

    public function forceDelete(Request $request, $id)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $aktivitas = Aktivitas::onlyTrashed()->findOrFail($id);
        $aktivitas->forceDelete();

        return redirect()->route('aktivitas.trash')->with('status', 'Aktivitas dihapus permanen.');
    }

    public function print(Request $request)
    {
        $items = Aktivitas::with('pengguna')
            ->orderByDesc('id_aktivitas')
            ->get();

        return view('aktivitas.print', compact('items'));
    }
}

