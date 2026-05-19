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

        // Hitung Overview Stats berdasarkan status langganan (aktif/nonaktif)
        $statsQuery = IndibizData::query();
        if ($request->user()->role !== Pengguna::ROLE_ADMIN) {
            $statsQuery->where('id_pengguna', $request->user()->id_pengguna);
        }

        $totalIndibiz = (clone $statsQuery)->count();
        $aktifCount = (clone $statsQuery)->whereIn('status_langganan', ['aktif', 'Aktif'])->count();
        $nonaktifCount = (clone $statsQuery)->whereIn('status_langganan', ['nonaktif', 'Nonaktif'])->count();

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_input', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_input', $request->tahun);
        }

        if ($request->filled('tipe')) {
            $query->where('jenis_layanan', $request->tipe);
        }

        $limit = in_array($request->get('limit'), [5, 10, 20, 25]) ? (int) $request->get('limit') : 10;

        // Gunakan paginate() untuk menggantikan get() agar navigasi halaman berfungsi
        return view('indibiz.index', [
            'items' => $query->paginate($limit)->withQueryString(),
            'totalIndibiz' => $totalIndibiz,
            'aktifCount' => $aktifCount,
            'nonaktifCount' => $nonaktifCount,
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
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $validatedData['id_pengguna'] = $request->user()->id_pengguna;
        $validatedData['tanggal_input'] = now();

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

    public function print(Request $request)
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

        $items = $query->get();

        $bulanNama = [
            '01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni',
            '07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
        ];
        $filterBulan = $request->filled('bulan') ? ($bulanNama[$request->bulan] ?? null) : null;
        $filterTahun = $request->get('tahun');
        $filterTipe = $request->get('tipe');

        return view('indibiz.print', compact('items', 'filterBulan', 'filterTahun', 'filterTipe'));
    }
}