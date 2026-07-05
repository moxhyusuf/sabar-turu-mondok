<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use Illuminate\Http\Request;
use App\Models\KostFasilitas;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Renderer\Image\Png;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KostController extends Controller
{
    public function printBarcode($id)
    {
        $kost = Kost::findOrFail($id);

        // URL khusus report view
        $url = route('kost.report', $kost->id);

        // Generate QR SVG
        $qrSvg = QrCode::format('svg')->size(300)->generate($url);

        return view('admin.kost.barcode', [
            'kost' => $kost,
            'qrSvg' => $qrSvg
        ]);
    }

    public function showReport($id)
    {
        $kost = Kost::with(['fasilitas', 'images', 'user'])->findOrFail($id);
        return view('kost.report', compact('kost'));
    }




    public function detail($id)
    {
        $kost = Kost::with(['images', 'fasilitas'])->findOrFail($id);
        
        $rekomendasi = Kost::with(['images', 'fasilitas'])
            ->where('id', '!=', $id)
            ->where('user_id', $kost->user_id)
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        // Jika rekomendasi kurang dari 3, ambil kost lain secara acak
        if ($rekomendasi->count() < 3) {
            $tambahan = Kost::with(['images', 'fasilitas'])
                ->where('id', '!=', $id)
                ->whereNotIn('id', $rekomendasi->pluck('id'))
                ->inRandomOrder()
                ->take(3 - $rekomendasi->count())
                ->get();
            $rekomendasi = $rekomendasi->merge($tambahan);
        }
            
        return view('pages.detailkost', compact('kost', 'rekomendasi'));
    }


    public function publicIndex()
    {
        $about = \App\Models\AboutKami::first();

        // Ambil 6 kost terbaru (netral)
        $items = \App\Models\Kost::with(['images', 'user'])
            ->latest()
            ->take(6)
            ->get();
        
        $alur = \App\Models\AlurPendaftaran::all();

        return view('pages.index', compact('about', 'items', 'alur'));
    }


    public function userKost(Request $request)
    {
        $keyword = $request->keyword;
        $query = Kost::with(['images', 'fasilitas']);
        
        if($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_kost', 'LIKE', "%$keyword%")
                    ->orWhere('nama_pemilik', 'LIKE', "%$keyword%")
                    ->orWhere('alamat', 'LIKE', "%$keyword%")
                    ->orWhere('kelurahan', 'LIKE', "%$keyword%")
                    ->orWhere('contact_person', 'LIKE', "%$keyword%")
                    ->orWhere('jenis_kost', 'LIKE', "%$keyword%")
                    ->orWhere('harga', 'LIKE', "%$keyword%")
                    ->orWhere('lokasi_pemondokan', 'LIKE', "%$keyword%")
                    ->orWhere('jumlah_kamar', 'LIKE', "%$keyword%")
                    ->orWhere('kamar_tersedia', 'LIKE', "%$keyword%");
            });
        }
        
        $items = $query->get();
        return view('pages.pemondokan', compact('items'));
    }




    // ===============================
    //  INDEX : SESUAIKAN ROLE USER
    // ===============================
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // admin melihat semua data
            $kosts = Kost::with(['fasilitas', 'images'])->get();
        } else {
            // pemilik kost melihat hanya data miliknya
            $kosts = Kost::with(['fasilitas', 'images'])
                ->where('user_id', $user->id)
                ->get();
        }

        return view('admin.kost.index', compact('kosts'));
    }


    // ===============================
    //  SEARCH DATA KOST (ADMIN/PEMILIK)
    // ===============================
    public function search(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->keyword;
        $query = Kost::with(['images', 'fasilitas']);

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_kost', 'LIKE', "%$keyword%")
                    ->orWhere('nama_pemilik', 'LIKE', "%$keyword%")
                    ->orWhere('nik_pemilik', 'LIKE', "%$keyword%")
                    ->orWhere('contact_person', 'LIKE', "%$keyword%")
                    ->orWhere('alamat', 'LIKE', "%$keyword%")
                    ->orWhere('kelurahan', 'LIKE', "%$keyword%")
                    ->orWhere('jenis_kost', 'LIKE', "%$keyword%")
                    ->orWhere('jumlah_kamar', 'LIKE', "%$keyword%")
                    ->orWhere('harga', 'LIKE', "%$keyword%")

                    // =========================
                    // SEARCH hubungan fasilitas
                    // =========================
                    ->orWhereHas('fasilitas', function ($f) use ($keyword) {
                        $f->where('lahan_parkir', 'LIKE', "%$keyword%")
                            ->orWhere('pagar', 'LIKE', "%$keyword%")
                            ->orWhere('cctv', 'LIKE', "%$keyword%")
                            ->orWhere('ac_kipas', 'LIKE', "%$keyword%")
                            ->orWhere('meteran_listrik', 'LIKE', "%$keyword%")
                            ->orWhere('wifi', 'LIKE', "%$keyword%")
                            ->orWhere('peraturan_penghuni', 'LIKE', "%$keyword%")
                            ->orWhere('penjaga', 'LIKE', "%$keyword%")
                            ->orWhere('kasur', 'LIKE', "%$keyword%")
                            ->orWhere('bantal', 'LIKE', "%$keyword%")
                            ->orWhere('lemari', 'LIKE', "%$keyword%")
                            ->orWhere('guling', 'LIKE', "%$keyword%")
                            ->orWhere('kursi', 'LIKE', "%$keyword%")
                            ->orWhere('meja', 'LIKE', "%$keyword%")
                            ->orWhere('meja_rias', 'LIKE', "%$keyword%")
                            ->orWhere('mesin_cuci', 'LIKE', "%$keyword%")
                            ->orWhere('r_jemur', 'LIKE', "%$keyword%")
                            ->orWhere('dapur', 'LIKE', "%$keyword%");
                    });
            });
        }

        $kosts = $query->get();

        return view('admin.kost.index', compact('kosts'));
    }


    // Cetak Laporan
    public function cetakLaporan(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->keyword;
        $query = Kost::with(['images', 'fasilitas']);

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_kost', 'LIKE', "%$keyword%")
                    ->orWhere('nama_pemilik', 'LIKE', "%$keyword%")
                    ->orWhere('nik_pemilik', 'LIKE', "%$keyword%")
                    ->orWhere('contact_person', 'LIKE', "%$keyword%")
                    ->orWhere('alamat', 'LIKE', "%$keyword%")
                    ->orWhere('kelurahan', 'LIKE', "%$keyword%")
                    ->orWhere('jenis_kost', 'LIKE', "%$keyword%")
                    ->orWhere('jumlah_kamar', 'LIKE', "%$keyword%")
                    ->orWhere('harga', 'LIKE', "%$keyword%")
                    ->orWhereHas('fasilitas', function ($f) use ($keyword) {
                        $f->where('lahan_parkir', 'LIKE', "%$keyword%")
                            ->orWhere('pagar', 'LIKE', "%$keyword%")
                            ->orWhere('cctv', 'LIKE', "%$keyword%")
                            ->orWhere('ac_kipas', 'LIKE', "%$keyword%")
                            ->orWhere('meteran_listrik', 'LIKE', "%$keyword%")
                            ->orWhere('wifi', 'LIKE', "%$keyword%")
                            ->orWhere('peraturan_penghuni', 'LIKE', "%$keyword%")
                            ->orWhere('penjaga', 'LIKE', "%$keyword%")
                            ->orWhere('kasur', 'LIKE', "%$keyword%")
                            ->orWhere('bantal', 'LIKE', "%$keyword%")
                            ->orWhere('lemari', 'LIKE', "%$keyword%")
                            ->orWhere('guling', 'LIKE', "%$keyword%")
                            ->orWhere('kursi', 'LIKE', "%$keyword%")
                            ->orWhere('meja', 'LIKE', "%$keyword%")
                            ->orWhere('meja_rias', 'LIKE', "%$keyword%")
                            ->orWhere('mesin_cuci', 'LIKE', "%$keyword%")
                            ->orWhere('r_jemur', 'LIKE', "%$keyword%")
                            ->orWhere('dapur', 'LIKE', "%$keyword%");
                    });
            });
        }

        $data = $query->get();

        // Tambahan penting BIAR NGGA ERROR
        $tanggal_cetak = now()->format('d-m-Y');
        $filter_kost   = $keyword ?: 'Semua';

        return view('admin.kost.cetaklaporan', [
            'data'          => $data,
            'tanggal_cetak' => $tanggal_cetak,
            'filter_kost'   => $filter_kost,
            'keyword'       => $keyword,
        ]);
    }





    public function create()
    {
        return view('admin.kost.create');
    }

    // ===============================
    //  STORE : AUTO SIMPAN user_id
    // ===============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kost' => 'required',
            'nama_pemilik' => 'required',
            'nik_pemilik' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'contact_person' => 'required',
            'nib' => 'required',
            'jenis_kost' => 'required',
            'type_kamar' => 'nullable',
            'jumlah_kamar' => 'required|integer',
            'harga' => 'required|integer',
            'lokasi_pemondokan' => 'nullable'
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // SIMPAN DATA KOST
        $nibValue = $request->nib;
        $statusIzin = (!empty($nibValue) && $nibValue !== '-') ? 'berizin' : 'belum_berizin';

        $kost = Kost::create([
            'user_id'           => $user->id,
            'nama_kost'         => $request->nama_kost,
            'nama_pemilik'      => $request->nama_pemilik,
            'nik_pemilik'       => $request->nik_pemilik,
            'alamat'            => $request->alamat,
            'kelurahan'         => $request->kelurahan,
            'contact_person'    => $request->contact_person,
            'nib'               => $request->nib,
            'jenis_kost'        => $request->jenis_kost,
            'type_kamar'        => ($request->type_kamar === '-' || empty($request->type_kamar)) ? null : $request->type_kamar,
            'jumlah_kamar'      => $request->jumlah_kamar,
            'harga'             => $request->harga,
            'lokasi_pemondokan' => $request->lokasi_pemondokan,
            'peraturan_kost'    => $request->peraturan_kost,
            'nama_bank'         => $request->nama_bank,
            'no_rekening'       => $request->no_rekening,
            'status_izin'       => $statusIzin,
        ]);

        // Inisialisasi kamar_tersedia
        $kost->syncKamarTersedia();

        // ===========================
        // SIMPAN FASILITAS
        // ===========================
        $fasilitasKeys = [
            'lahan_parkir',
            'pagar',
            'cctv',
            'ac_kipas',
            'meteran_listrik',
            'wifi',
            'peraturan_penghuni',
            'penjaga',
            'kasur',
            'bantal',
            'lemari',
            'guling',
            'kursi',
            'meja',
            'meja_rias',
            'mesin_cuci',
            'r_jemur',
            'dapur',
        ];

        $dataFasilitas = ['kost_id' => $kost->id];

        foreach ($fasilitasKeys as $key) {
            $dataFasilitas[$key] = $request->has($key);
        }

        // Simpan fasilitas custom
        $dataFasilitas['fasilitas_custom'] = $request->fasilitas_custom;

        KostFasilitas::create($dataFasilitas);

        // ===========================
        // SIMPAN GAMBAR (MULTIPLE)
        // ===========================
        if ($request->hasFile('images')) {

            $files = $request->file('images');

            // Pastikan selalu array meskipun upload hanya 1 file
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $image) {
                $fileName = uniqid() . '-' . $image->getClientOriginalName();
                $image->storeAs('kost', $fileName, 'public');

                $kost->images()->create([
                    'image_path' => 'kost/' . $fileName
                ]);
            }
        }


        return redirect()->route('kost.index')
            ->with('success', 'Data kost berhasil ditambahkan!');
    }



    public function edit($id)
    {
        $user = Auth::user();
        $query = Kost::with('images', 'fasilitas');
        
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $kost = $query->findOrFail($id);
        return view('admin.kost.edit', compact('kost'));
    }


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $query = Kost::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $kost = $query->findOrFail($id);

        $nibValue = $request->nib;
        $statusIzin = (!empty($nibValue) && $nibValue !== '-') ? 'berizin' : 'belum_berizin';

        $updateData = [
            'nama_kost'         => $request->nama_kost,
            'nama_pemilik'      => $request->nama_pemilik,
            'nik_pemilik'       => $request->nik_pemilik,
            'alamat'            => $request->alamat,
            'kelurahan'         => $request->kelurahan,
            'contact_person'    => $request->contact_person,
            'nib'               => $request->nib,
            'jenis_kost'        => $request->jenis_kost,
            'type_kamar'        => ($request->type_kamar === '-' || empty($request->type_kamar)) ? null : $request->type_kamar,
            'jumlah_kamar'      => $request->jumlah_kamar,
            'harga'             => $request->harga,
            'lokasi_pemondokan' => $request->lokasi_pemondokan,
            'peraturan_kost'    => $request->peraturan_kost,
            'nama_bank'         => $request->nama_bank,
            'no_rekening'       => $request->no_rekening,
            'status_izin'       => $statusIzin,
        ];

        $kost->update($updateData);

        // Berikan kamar_tersedia nilai awal jika baru atau update sync jika jumlah_kamar berubah
        $kost->syncKamarTersedia();

        if ($kost->fasilitas) {

            $fasilitasKeys = [
                'lahan_parkir',
                'pagar',
                'cctv',
                'ac_kipas',
                'meteran_listrik',
                'wifi',
                'peraturan_penghuni',
                'penjaga',
                'kasur',
                'bantal',
                'lemari',
                'guling',
                'kursi',
                'meja',
                'meja_rias',
                'mesin_cuci',
                'r_jemur',
                'dapur',
            ];

            $dataUpdate = [];

            foreach ($fasilitasKeys as $key) {
                $dataUpdate[$key] = $request->has($key);
            }

            // Update fasilitas custom
            $dataUpdate['fasilitas_custom'] = $request->fasilitas_custom;

            $kost->fasilitas->update($dataUpdate);
        }

        // HAPUS GAMBAR
        if ($request->delete_images) {
            foreach ($request->delete_images as $imgId) {
                $img = $kost->images()->find($imgId);

                if ($img) {
                    \Storage::delete('public/' . $img->image_path);
                    $img->delete();
                }
            }
        }

        // UPLOAD GAMBAR BARU
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '-' . $image->getClientOriginalName();
                $image->storeAs('kost', $fileName, 'public');

                $kost->images()->create([
                    'image_path' => 'kost/' . $fileName
                ]);
            }
        }

        return redirect()->route('kost.index')
            ->with('success', 'Data kost berhasil diperbarui!');
    }

    public function showKost($id)
    {
        $user = Auth::user();
        $query = Kost::with(['fasilitas', 'images', 'user']);

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $kost = $query->findOrFail($id);

        return view('admin.kost.show', compact('kost'));
    }



    public function destroy($id)
    {
        $user = Auth::user();
        $query = Kost::query();

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $kost = $query->findOrFail($id);

        // Hapus gambar
        foreach ($kost->images as $img) {
            \Storage::delete('public/' . $img->image_path);
            $img->delete();
        }

        // Hapus fasilitas
        $kost->fasilitas()->delete();

        // Hapus kost
        $kost->delete();

        return redirect()->route('kost.index')
            ->with('success', 'Data kost berhasil dihapus!');
    }
}
