@extends('layout.app')

@section('title', 'Detail Kost')
@section('page-title', 'Detail Kost')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        {{-- Header --}}
        <div class="card-header bg-secondary text-white text-center">
            <h3 class="mb-0">{{ $kost->nama_kost }}</h3>
        </div>

        {{-- Body --}}
        <div class="card-body bg-white">
            <div class="row">
                {{-- Info Kost --}}
                <div class="col-md-6">
                    <h5>Informasi Kost</h5>
                    <hr>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Pemilik</th>
                                <td>{{ $kost->nama_pemilik }}</td>
                            </tr>
                            <!-- <tr>
                                <th>NIK</th>
                                <td>{{ $kost->nik_pemilik }}</td>
                            </tr> -->
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $kost->alamat }}, {{ $kost->kelurahan }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person</th>
                                <td>{{ $kost->contact_person }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kost</th>
                                <td>{{ $kost->jenis_kost }}</td>
                            </tr>
                            <tr>
                                <th>Jumlah Kamar</th>
                                <td>{{ $kost->jumlah_kamar }}</td>
                            </tr>
                            <tr>
                                <th>Sisa Kamar</th>
                                <td>{{ $kost->kamar_tersedia }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>Rp {{ number_format($kost->harga,0,',','.') }}</td>
                            </tr>
                            @if($kost->lokasi_pemondokan)
                            <tr>
                                <th>Lokasi Pemondokan</th>
                                <td>{{ $kost->lokasi_pemondokan }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Fasilitas --}}
                <div class="col-md-6">
                    <h5>Fasilitas</h5>
                    <hr>

                    @php
                    $f = $kost->fasilitas;
                    @endphp

                    <ul class="list-unstyled ms-3">

                        @if($f->lahan_parkir) <li>• Lahan Parkir</li> @endif
                        @if($f->pagar) <li>• Pagar</li> @endif
                        @if($f->cctv) <li>• CCTV</li> @endif
                        @if($f->ac_kipas) <li>• AC / Kipas</li> @endif
                        @if($f->meteran_listrik) <li>• Meteran Listrik</li> @endif
                        @if($f->wifi) <li>• WiFi</li> @endif
                        @if($f->peraturan_penghuni) <li>• Peraturan Penghuni</li> @endif
                        @if($f->penjaga) <li>• Penjaga</li> @endif

                        {{-- Fasilitas tambahan --}}
                        @if($f->kasur) <li>• Kasur</li> @endif
                        @if($f->bantal) <li>• Bantal</li> @endif
                        @if($f->lemari) <li>• Lemari</li> @endif
                        @if($f->guling) <li>• Guling</li> @endif
                        @if($f->kursi) <li>• Kursi</li> @endif
                        @if($f->meja) <li>• Meja Belajar</li> @endif
                        @if($f->meja_rias) <li>• Meja Rias</li> @endif
                        @if($f->mesin_cuci) <li>• Mesin Cuci</li> @endif
                        @if($f->r_jemur) <li>• Ruang Jemur</li> @endif
                        @if($f->dapur) <li>• Dapur</li> @endif

                        {{-- Fasilitas Custom --}}
                        @if($kost->fasilitas->fasilitas_custom)
                            @foreach($kost->fasilitas->fasilitas_custom as $custom)
                                <li class="facility-item">• {{ $custom }}</li>
                            @endforeach
                        @endif

                    </ul>
                </div>


            </div>

            {{-- Galeri Gambar --}}
            @if($kost->images->count() > 0)
            <hr>
            <h5 class="mt-3">Galeri Gambar</h5>
            <div class="row">
                @foreach($kost->images as $image)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Gambar Kost">
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Tombol Kembali --}}
            <a href="{{ route('kost.index') }}" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('barcode.kost', $kost->id) }}" target="_blank"
                class="btn btn-primary mt-3">
                <i class="fas fa-download"></i> Barcode
            </a>

        </div>
    </div>
</div>
@endsection