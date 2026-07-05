<?php

namespace App\Http\Controllers;

use App\Models\AlurPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlurPendaftaranController extends Controller
{
    // ==========================================
    // INDEX (Renders the single Edit page)
    // ==========================================
    public function index()
    {
        $alurPemondokan = AlurPendaftaran::firstOrCreate(
            ['id' => 1],
            ['title' => 'Alur Pendaftaran Rumah Pemondokan', 'img' => '']
        );

        $alurKos = AlurPendaftaran::firstOrCreate(
            ['id' => 2],
            ['title' => 'Alur Penyewaan Kos', 'img' => '']
        );

        return view('admin.alur_pendaftaran.edit', compact('alurPemondokan', 'alurKos'));
    }

    // ==========================================
    // PUBLIC ALUR (Renders public user page)
    // ==========================================
    public function publicAlur()
    {
        $data = AlurPendaftaran::orderBy('id', 'asc')->get();
        return view('pages.alur', compact('data'));
    }

    // ==========================================
    // UPDATE ALL (Handles Edit Page Form Submission)
    // ==========================================
    public function updateAll(Request $request)
    {
        $request->validate([
            'img_pemondokan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'img_kos' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $pemondokan = AlurPendaftaran::firstOrCreate(
            ['id' => 1],
            ['title' => 'Alur Pendaftaran Rumah Pemondokan', 'img' => '']
        );

        $kos = AlurPendaftaran::firstOrCreate(
            ['id' => 2],
            ['title' => 'Alur Penyewaan Kos', 'img' => '']
        );

        // Keep titles explicitly synced to match label
        $pemondokan->update(['title' => 'Alur Pendaftaran Rumah Pemondokan']);
        $kos->update(['title' => 'Alur Penyewaan Kos']);

        // 1. Handle Pemondokan Image
        if ($request->hasFile('img_pemondokan')) {
            // Delete old file
            if ($pemondokan->img) {
                Storage::disk('public')->delete($pemondokan->img);
            }
            $path = $request->file('img_pemondokan')->store('alur_pendaftaran', 'public');
            $pemondokan->update(['img' => $path]);
        } elseif ($request->has('remove_pemondokan') && $request->remove_pemondokan == '1') {
            if ($pemondokan->img) {
                Storage::disk('public')->delete($pemondokan->img);
            }
            $pemondokan->update(['img' => '']);
        }

        // 2. Handle Kos Image
        if ($request->hasFile('img_kos')) {
            // Delete old file
            if ($kos->img) {
                Storage::disk('public')->delete($kos->img);
            }
            $path = $request->file('img_kos')->store('alur_pendaftaran', 'public');
            $kos->update(['img' => $path]);
        } elseif ($request->has('remove_kos') && $request->remove_kos == '1') {
            if ($kos->img) {
                Storage::disk('public')->delete($kos->img);
            }
            $kos->update(['img' => '']);
        }

        return redirect()->route('alur_pendaftaran.index')
            ->with('success', 'Alur pendaftaran berhasil diperbarui.');
    }
}
