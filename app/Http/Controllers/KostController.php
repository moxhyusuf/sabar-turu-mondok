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

        // URL halaman yang akan terbuka ketika barcode di-scan
        $url = route('detailkost', $kost->id);

        // Generate QR SVG
        $qrSvg = QrCode::format('svg')->size(300)->generate($url);

        return view('admin.kost.barcode', [
            'kost' => $kost,
            'qrSvg' => $qrSvg
        ]);
    }




    public function detail($id)
    {
        $kost = Kost::with(['images', 'fasilitas'])->findOrFail($id);
        return view('pages.detailkost', compact('kost'));
    }


    public function publicIndex()
    {
        $about = \App\Models\AboutKami::first();

        $items = \App\Models\Kost::with('images')
            ->orderBy('jumlah_kamar', 'DESC')
            ->take(3)
            ->get();

        return view('pages.index', compact('about', 'items'));
    }


    public function userKost()
    {
        $items = Kost::with(['images', 'fasilitas'])->get();
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
        $keyword = $request->keyword;

        $query = Kost::with(['images', 'fasilitas']);

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
        $keyword = $request->keyword;

        $query = Kost::with(['images', 'fasilitas']);

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
            'jumlah_kamar' => 'required|integer',
            'harga' => 'required|integer',
            'lokasi_pemondokan' => 'nullable'
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // SIMPAN DATA KOST
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
            'jumlah_kamar'      => $request->jumlah_kamar,
            'harga'             => $request->harga,
            'lokasi_pemondokan' => $request->lokasi_pemondokan,
        ]);

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
        $kost = Kost::with('images', 'fasilitas')->findOrFail($id);
        return view('admin.kost.edit', compact('kost'));
    }


    public function update(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        $kost->update([
            'nama_kost'         => $request->nama_kost,
            'nama_pemilik'      => $request->nama_pemilik,
            'nik_pemilik'       => $request->nik_pemilik,
            'alamat'            => $request->alamat,
            'kelurahan'         => $request->kelurahan,
            'contact_person'    => $request->contact_person,
            'nib'               => $request->nib,
            'jenis_kost'        => $request->jenis_kost,
            'jumlah_kamar'      => $request->jumlah_kamar,
            'harga'             => $request->harga,
            'lokasi_pemondokan' => $request->lokasi_pemondokan,
        ]);

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
        // Ambil data kost beserta fasilitas dan images
        $kost = Kost::with(['fasilitas', 'images', 'user'])->findOrFail($id);

        return view('admin.kost.show', compact('kost'));
    }



    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);

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
