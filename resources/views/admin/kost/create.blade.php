@extends('layout.app')

@section('title', 'Tambah Kost')
@section('page-title', 'Tambah Data Kost')

@section('content')
<section class="content mt-4">
    <div class="container-fluid">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Data Kost</h5>
            </div>

            <form action="{{ route('kost.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">

                    {{-- ================= DATA KOST ================= --}}
                    <h6 class="mb-3"><strong>Data Kost</strong></h6>

                    <div class="mb-3">
                        <label class="form-label">Nama Usaha Kost</label>
                        <input type="text" name="nama_kost" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Kost (RT/RW)</label>
                        <textarea name="alamat" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelurahan</label>
                        <input type="text" name="kelurahan" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama_pemilik" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Pemilik</label>
                            <input type="text" name="nik_pemilik" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">NIB (Nomor Induk Berusaha)</label>
                        <input type="text" name="nib" class="form-control" placeholder="13 digit (opsional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. HP / WhatsApp</label>
                        <input type="text" name="contact_person" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Kost</label>
                            <select name="jenis_kost" class="form-control" required>
                                <option value="putra">Putra</option>
                                <option value="putri">Putri</option>
                                <option value="campur">Keluarga</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah Kamar</label>
                            <input type="number" name="jumlah_kamar" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Harga Per Bulan</label>
                            <input type="number" name="harga" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi Pemondokan</label>
                        <select name="lokasi_pemondokan" class="form-control">
                            <option value="satu_atap">Satu Atap</option>
                            <option value="terpisah">Terpisah</option>
                        </select>
                    </div>

                    <hr>

                    {{-- ================= FASILITAS ================= --}}
                    <h6 class="mb-3"><strong>Fasilitas Kost</strong></h6>

                    <div class="row">
                        @php
                        $fasilitas = [
                        'lahan_parkir'=>'Lahan Parkir','pagar'=>'Pagar','cctv'=>'CCTV',
                        'ac_kipas'=>'AC / Kipas','meteran_listrik'=>'Meteran Listrik',
                        'wifi'=>'WiFi','peraturan_penghuni'=>'Peraturan Penghuni',
                        'penjaga'=>'Penjaga','kasur'=>'Kasur','bantal'=>'Bantal',
                        'lemari'=>'Lemari','guling'=>'Guling','kursi'=>'Kursi',
                        'meja'=>'Meja','meja_rias'=>'Meja Rias','mesin_cuci'=>'Mesin Cuci',
                        'r_jemur'=>'Ruang Jemur','dapur'=>'Dapur'
                        ];
                        @endphp

                        @foreach($fasilitas as $key => $label)
                        <div class="col-md-3 col-sm-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $key }}" id="{{ $key }}">
                                <label class="form-check-label" for="{{ $key }}">
                                    {{ $label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    {{-- ================= FOTO ================= --}}
                    <div class="mb-3">
                        <label class="form-label">Upload Foto Kost</label>
                        <input type="file" name="images[]" multiple class="form-control">
                        <small class="text-muted">Bisa upload lebih dari satu foto</small>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                    <a href="{{ route('kost.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>

    </div>
</section>
@endsection
