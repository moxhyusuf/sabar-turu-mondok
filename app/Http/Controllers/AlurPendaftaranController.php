<?php

namespace App\Http\Controllers;

use App\Models\AlurPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlurPendaftaranController extends Controller
{
    // =========================
    // HALAMAN ADMIN - INDEX
    // =========================
    public function index()
    {
        $data = AlurPendaftaran::all();
        return view('admin.alur_pendaftaran.index', compact('data'));
    }

    // =========================
    // HALAMAN PUBLIC (USER)
    // =========================
    public function publicAlur()
    {
        $data = AlurPendaftaran::all();
        return view('pages.alur', compact('data'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('admin.alur_pendaftaran.create');
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'img' => 'required|image|max:2048',
        ]);

        $img = null;

        if ($request->hasFile('img')) {
            $img = $request->file('img')->store('alur_pendaftaran', 'public');
        }

        AlurPendaftaran::create([
            'img' => $img,
        ]);

        return redirect()->route('alur_pendaftaran.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $data = AlurPendaftaran::findOrFail($id);
        return view('admin.alur_pendaftaran.edit', compact('data'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'img' => 'nullable|image|max:2048',
        ]);

        $data = AlurPendaftaran::findOrFail($id);

        $img = $data->img;

        // Cek apakah ada gambar baru
        if ($request->hasFile('img')) {

            // Hapus gambar lama
            if ($data->img) {
                Storage::disk('public')->delete($data->img);
            }

            // Upload gambar baru
            $img = $request->file('img')->store('alur_pendaftaran', 'public');
        }

        $data->update([
            'img' => $img,
        ]);

        return redirect()->route('alur_pendaftaran.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $data = AlurPendaftaran::findOrFail($id);

        // Hapus gambar dari storage
        if ($data->img) {
            Storage::disk('public')->delete($data->img);
        }

        // Hapus data
        $data->delete();

        return redirect()->route('alur_pendaftaran.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
