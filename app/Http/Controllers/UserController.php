<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil data berdasarkan role
        $petugas = User::whereIn('role', ['admin', 'perpajakan', 'perizinan'])->get();
        $pemilikDekost = User::where('role', 'pemilik_dekost')->get();

        return view('admin.users.index', compact('petugas', 'pemilikDekost'));
    }

    // ==============================
    // FORM TAMBAH USER
    // ==============================
    public function create()
    {
        return view('admin.users.create');
    }

    // SIMPAN DATA USER BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6',
            'alamat'   => 'required|string|max:255',
            'role'     => 'required|in:admin,perpajakan,perizinan',
        ]);

        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'role'     => $request->role,
            'status'   => 'approved', // ADMIN/PERPAJAKAN/PERIZINAN = approved langsung
            'bukti_ktp' => null,      // admin tidak upload ktp
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }


    // ==============================
    // FORM EDIT USER
    // ==============================
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // PROSES UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi
        $request->validate([
            'nama'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        // Update field yang boleh diubah
        $user->nama = $request->nama;
        $user->username = $request->username;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Field lain TIDAK DIUBAH:
        // $user->role   → tetap
        // $user->status → tetap
        // $user->alamat → tetap
        // $user->bukti_ktp → tetap

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }


    // ==============================
    // HAPUS USER
    // ==============================
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ==============================
    // APPROVE USER (khusus pemilik dekost)
    // ==============================
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'User berhasil disetujui!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return redirect()->back()->with('error', 'Pendaftaran ditolak bukan warga Kanigaran.');
    }
}
