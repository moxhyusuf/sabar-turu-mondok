<?php

namespace App\Http\Controllers;

use App\Models\AboutKami;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutKamiController extends Controller
{
    // halaman admin INDEX
    public function index()
    {
        $data = AboutKami::all();
        return view('admin.tentang_kami.index', compact('data'));
    }

    // halaman user
    public function publicAbout()
    {
        $about = AboutKami::first();
        return view('pages.about', compact('about'));
    }

    // CREATE
    public function create()
    {
        return view('admin.tentang_kami.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'tentang_kami' => 'required',
            'img' => 'nullable|image|max:2048',
        ]);

        $img = null;

        if ($request->hasFile('img')) {
            $img = $request->file('img')->store('tentang_kami', 'public');
        }

        AboutKami::create([
            'tentang_kami' => $request->tentang_kami,
            'img' => $img,
        ]);

        return redirect()->route('tentang_kami.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $data = AboutKami::findOrFail($id);
        return view('admin.tentang_kami.edit', compact('data'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'tentang_kami' => 'required',
            'img' => 'nullable|image|max:2048',
        ]);

        $data = AboutKami::findOrFail($id);

        $img = $data->img;

        // Jika upload gambar baru
        if ($request->hasFile('img')) {

            // Hapus gambar lama
            if ($data->img) {
                Storage::disk('public')->delete($data->img);
            }

            // Simpan gambar baru
            $img = $request->file('img')->store('tentang_kami', 'public');
        }

        $data->update([
            'tentang_kami' => $request->tentang_kami,
            'img' => $img,
        ]);

        return redirect()->route('tentang_kami.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    // DELETE
    public function destroy($id)
    {
        $data = AboutKami::findOrFail($id);

        if ($data->img) {
            Storage::disk('public')->delete($data->img);
        }

        $data->delete();

        return redirect()->route('tentang_kami.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
