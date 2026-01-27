<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** ===============
     *  TAMPILKAN LOGIN
     *  =============== */
    public function showLogin()
    {

        return view('auth.login');
    }

    /** ===============
     *  PROSES LOGIN
     *  =============== */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Hanya pemilik dekost yang harus diverifikasi
            if ($user->role === 'pemilik_dekost') {

                // Jika ditolak
                if ($user->status === 'rejected') {
                    Auth::logout();
                    return back()->with('error', 'Pendaftaran ditolak karna lokasi usaha diluar wilayah Kecamatan Kanigaran.');
                }

                // Jika masih pending
                if ($user->status === 'pending') {
                    Auth::logout();
                    return back()->with('warning', 'Akun Anda masih dalam proses verifikasi pihak kecamatan.');
                }
            }

            // Jika approved → boleh masuk
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah.');
    }




    /** ===============
     *  TAMPILKAN REGISTER
     *  =============== */
    public function showRegister()
    {
        return view('auth.register');
    }

    /** ===============
     *  REGISTRASI USER
     *  =============== */
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|confirmed|min:5',
            'alamat' => 'required',
            'bukti_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ktpPath = $request->file('bukti_ktp')->store('bukti_ktp', 'public');

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'bukti_ktp' => $ktpPath,
            'role' => 'pemilik_dekost',
            'status' => 'pending',
        ]);

        return redirect('/register')->with('success', 'Registrasi berhasil! Tunggu persetujuan dari pihak Kecamatan.');
    }



    /** ===============
     *  LOGOUT
     *  =============== */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Kamu berhasil logout.');
    }
}
