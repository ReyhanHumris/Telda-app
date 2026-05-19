<?php

namespace App\Http\Controllers;

use App\Models\IndibizData;
use App\Models\Pengguna;
use App\Models\Aktivitas; // Tambahkan import model Aktivitas
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

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_input', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_input', $request->tahun);
        }

        if ($request->filled('tipe')) {
            $query->where('jenis_layanan', $request->tipe);
        }

        // Gunakan paginate() untuk menggantikan get() agar navigasi halaman berfungsi
        return view('indibiz.index', [
            'items' => $query->paginate(10)->withQueryString(), 
        ]);
    }

    public function create()
    {
        return view('indibiz.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'nama_perusahaan' => ['required', 'string', 'max:100'],
            'alamat_perusahaan' => ['required', 'string'],
            'jenis_layanan' => ['required', 'string', 'max:50'],
            'status_langganan' => ['required', 'in:aktif,nonaktif'],
        ]);

        $validatedData['id_pengguna'] = $request->user()->id_pengguna;


        $indibiz = IndibizData::create($validatedData);


        Aktivitas::create([
            'nama_aktivitas' => 'Input data Baru',
            'tanggal_aktivitas' => now(), // Menggunakan helper Carbon
            'keterangan' => 'Input data Indibiz baru: ' . $indibiz->nama_perusahaan,
            'id_pengguna' => $request->user()->id_pengguna, // Sesuaikan dengan id_pengguna sistem Anda
        ]);

        return redirect()->route('indibiz.index')->with('status', 'Data Indibiz berhasil disimpan.');
    }

    public function destroy(Request $request, IndibizData $indibiz)
    {
        $user = $request->user();
        $allowed = Gate::allows('admin') || $indibiz->id_pengguna === $user->id_pengguna;

        if (! $allowed) {
            abort(403);
        }

        // Logika Otomatis: Catat log saat data dihapus (Opsional)
        Aktivitas::create([
            'nama_aktivitas' => 'Menghapus data',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus data Indibiz: ' . $indibiz->nama_perusahaan,
            'id_pengguna' => $user->id_pengguna,
        ]);

        $indibiz->delete();

        return redirect()->route('indibiz.index')->with('status', 'Data Indibiz berhasil dihapus.');
    }

    public function trash(Request $request)
    {
        $query = IndibizData::onlyTrashed()->with('pengguna')->orderByDesc('id_indibiz');

        if ($request->user()->role !== Pengguna::ROLE_ADMIN) {
            $query->where('id_pengguna', $request->user()->id_pengguna);
        }

        return view('indibiz.trash', [
            'items' => $query->paginate(10),
        ]);
    }

    public function restore(Request $request, $id)
    {
        $indibiz = IndibizData::onlyTrashed()->findOrFail($id);
        
        if (!Gate::allows('admin') && $indibiz->id_pengguna !== $request->user()->id_pengguna) {
            abort(403);
        }

        $indibiz->restore();
        
        Aktivitas::create([
            'nama_aktivitas' => 'Restore Indibiz',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Memulihkan data Indibiz: ' . $indibiz->nama_perusahaan,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        return redirect()->back()->with('status', 'Data Indibiz berhasil dipulihkan.');
    }

    public function forceDelete(Request $request, $id)
    {
        $indibiz = IndibizData::onlyTrashed()->findOrFail($id);
        
        if (!Gate::allows('admin') && $indibiz->id_pengguna !== $request->user()->id_pengguna) {
            abort(403);
        }

        Aktivitas::create([
            'nama_aktivitas' => 'Hapus Permanen Indibiz',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus permanen data Indibiz: ' . $indibiz->nama_perusahaan,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        $indibiz->forceDelete();

        return redirect()->back()->with('status', 'Data Indibiz dihapus permanen.');
    }
}