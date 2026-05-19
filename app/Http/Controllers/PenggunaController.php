<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PenggunaController extends Controller
{
    public function index()
    {
        $items = Pengguna::orderByDesc('id_pengguna')->paginate(10);

        return view('pengguna.index', [
            'items' => $items,
        ]);
    }

    public function trashed()
    {
        $items = Pengguna::onlyTrashed()->orderByDesc('id_pengguna')->paginate(10);

        return view('pengguna.trashed', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        if (! Gate::allows('admin')) abort(403);
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        if (! Gate::allows('admin')) abort(403);

        $validatedData = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:pengguna'],
            'role' => ['required', 'in:admin,officer'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $validatedData['dibuat_pada'] = now();
        $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $filename, 'public');
            $validatedData['foto'] = $filename;
        }

        $pengguna = Pengguna::create($validatedData);

        Aktivitas::create([
            'nama_aktivitas' => 'Tambah Pengguna',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menambahkan pengguna baru: ' . $pengguna->nama_lengkap,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        return redirect()->route('pengguna.index')->with('status', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(Pengguna $pengguna)
    {
        if (! Gate::allows('admin')) abort(403);
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        if (! Gate::allows('admin')) abort(403);

        $validatedData = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', \Illuminate\Validation\Rule::unique('pengguna')->ignore($pengguna->id_pengguna, 'id_pengguna')],
            'role' => ['required', 'in:admin,officer'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($request->hasFile('foto')) {
            if ($pengguna->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('profile/' . $pengguna->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . $pengguna->id_pengguna . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile', $filename, 'public');
            $validatedData['foto'] = $filename;
        }

        $pengguna->update($validatedData);

        Aktivitas::create([
            'nama_aktivitas' => 'Update Pengguna',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Memperbarui pengguna: ' . $pengguna->nama_lengkap,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        return redirect()->route('pengguna.index')->with('status', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Request $request, Pengguna $pengguna)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        // Prevent deleting yourself
        if ($request->user()->id_pengguna === $pengguna->id_pengguna) {
            return redirect()->back()->with('status', 'Anda tidak dapat menghapus akun sendiri.');
        }

        Aktivitas::create([
            'nama_aktivitas' => 'Menghapus Pengguna',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus pengguna: ' . $pengguna->nama_lengkap,
            'id_pengguna' => $request->user()->id_pengguna,
        ]);

        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('status', 'Pengguna berhasil dihapus.');
    }

    public function restore($id)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $user = Pengguna::withTrashed()->findOrFail($id);
        $user->restore();

        Aktivitas::create([
            'nama_aktivitas' => 'Restore Pengguna',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Mengembalikan pengguna: ' . $user->nama_lengkap,
            'id_pengguna' => auth()->user()->id_pengguna,
        ]);

        return redirect()->route('pengguna.trashed')->with('status', 'Pengguna telah dipulihkan.');
    }

    public function forceDelete($id)
    {
        if (! Gate::allows('admin')) {
            abort(403);
        }

        $user = Pengguna::withTrashed()->findOrFail($id);
        Aktivitas::create([
            'nama_aktivitas' => 'Permanent Delete Pengguna',
            'tanggal_aktivitas' => now(),
            'keterangan' => 'Menghapus permanen pengguna: ' . $user->nama_lengkap,
            'id_pengguna' => auth()->user()->id_pengguna,
        ]);

        $user->forceDelete();

        return redirect()->route('pengguna.trashed')->with('status', 'Pengguna dihapus permanen.');
    }
}
