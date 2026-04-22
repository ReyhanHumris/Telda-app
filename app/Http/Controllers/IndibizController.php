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

        // Gunakan paginate() untuk menggantikan get() agar navigasi halaman berfungsi
        return view('indibiz.index', [
            'items' => $query->paginate(10), 
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

        // 2. Simpan Data Indibiz
        $indibiz = IndibizData::create($validatedData);

        // 3. Logika Otomatis: Catat ke Tabel Aktivitas
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
}