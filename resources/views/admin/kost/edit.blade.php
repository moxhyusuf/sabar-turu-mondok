@extends('layout.app')

@section('title', 'Edit Kost')

@section('page-title', 'Update Data Kost')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5>!</h5>
        </div>

        <form action="{{ route('kost.update', $kost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                {{-- DATA KOST --}}
                <div class="form-group">
                    <label>Nama Kost</label>
                    <input type="text" name="nama_kost" class="form-control" value="{{ $kost->nama_kost }}">
                </div>

                <div class="form-group mt-3">
                    <label>Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control" value="{{ $kost->nama_pemilik }}">
                </div>

                <div class="form-group mt-3">
                    <label>NIK Pemilik</label>
                    <input type="text" name="nik_pemilik" class="form-control" value="{{ $kost->nik_pemilik }}">
                </div>

                <div class="form-group mt-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ $kost->alamat }}">
                </div>

                <div class="form-group mt-3">
                    <label>Kelurahan</label>
                    <input type="text" name="kelurahan" class="form-control" value="{{ $kost->kelurahan }}">
                </div>

                <div class="form-group mt-3">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" class="form-control" value="{{ $kost->contact_person }}">
                </div>
                <div class="form-group mt-3">
                    <label>NIB (Nomor Induk Berusaha)</label>
                    <input type="text" name="nib" class="form-control" value="{{ $kost->nib }}">
                </div>






                <div class="row">
                    <div class="col-md-6 form-group mt-3">
                        <label>Jenis Kost</label>
                        <select name="jenis_kost" class="form-control">
                            <option value="putra" {{ $kost->jenis_kost == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ $kost->jenis_kost == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ $kost->jenis_kost == 'campur' ? 'selected' : '' }}>Keluarga</option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group mt-3">
                        <label>Type Kamar (Opsional)</label>
                        <select name="type_kamar" class="form-control">
                            <option value="-" {{ $kost->type_kamar == '-' || empty($kost->type_kamar) ? 'selected' : '' }}>-</option>
                            <option value="Tipe A (Standar)" {{ $kost->type_kamar == 'Tipe A (Standar)' ? 'selected' : '' }}>Tipe A (Standar)</option>
                            <option value="Tipe B (Menengah)" {{ $kost->type_kamar == 'Tipe B (Menengah)' ? 'selected' : '' }}>Tipe B (Menengah)</option>
                            <option value="Tipe C (VIP)" {{ $kost->type_kamar == 'Tipe C (VIP)' ? 'selected' : '' }}>Tipe C (VIP)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Jumlah Kamar</label>
                    <input type="number" name="jumlah_kamar" class="form-control" value="{{ $kost->jumlah_kamar }}">
                </div>

                <div class="form-group mt-3">
                    <label>Lokasi Pemondokan</label>
                    <select name="lokasi_pemondokan" class="form-control">
                        <option value="satu_atap" {{ $kost->lokasi_pemondokan == 'satu_atap' ? 'selected' : '' }}>Satu Atap</option>
                        <option value="terpisah" {{ $kost->lokasi_pemondokan == 'terpisah' ? 'selected' : '' }}>Terpisah</option>
                    </select>
                </div>


                <div class="form-group mt-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" value="{{ $kost->harga }}">
                </div>

                <div class="form-group mt-3">
                    <label>Nama Bank Pemilik</label>
                    <input type="text" name="nama_bank" class="form-control" value="{{ $kost->nama_bank }}">
                </div>

                <div class="form-group mt-3">
                    <label>No. Rekening Pemilik</label>
                    <input type="text" name="no_rekening" class="form-control" value="{{ $kost->no_rekening }}">
                </div>


                {{-- ================= TAMBAH FASILITAS CUSTOM ================= --}}
                <div class="form-group mt-3">
                    <label>Tambah Fasilitas Lainnya (Opsional)</label>
                    <div class="input-group">
                        <input type="text" id="customFasilitasInput" class="form-control" placeholder="Contoh: Parkir Motor Luas, Kamar Mandi Dalam">
                        <button type="button" class="btn btn-outline-primary" id="addCustomFasilitas">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <hr>

                {{-- FASILITAS --}}
                <h5>Fasilitas Kost</h5>

                @php
                $fasilitas = [
                'lahan_parkir' => 'Lahan Parkir',
                'pagar' => 'Pagar',
                'cctv' => 'CCTV',
                'ac_kipas' => 'AC / Kipas',
                'meteran_listrik' => 'Meteran Listrik',
                'wifi' => 'Wi-Fi',
                'peraturan_penghuni' => 'Peraturan Penghuni',
                'penjaga' => 'Penjaga',

                // Tambahan baru
                'kasur' => 'Kasur',
                'bantal' => 'Bantal',
                'lemari' => 'Lemari',
                'guling' => 'Guling',
                'kursi' => 'Kursi',
                'meja' => 'Meja',
                'meja_rias' => 'Meja Rias',
                'mesin_cuci' => 'Mesin Cuci',
                'r_jemur' => 'Ruang Jemur',
                'dapur' => 'Dapur',
                ];
                $fas = $kost->fasilitas;
                @endphp

                <div class="row" id="fasilitasContainer">
                    @foreach($fasilitas as $key => $label)
                    <div class="col-md-4 mb-2">
                        <label>
                            <input type="checkbox" name="{{ $key }}"
                                {{ $fas->$key ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    </div>
                    @endforeach

                    {{-- Render existing custom facilities --}}
                    @if($fas && $fas->fasilitas_custom)
                    @foreach($fas->fasilitas_custom as $custom)
                    <div class="col-md-4 mb-2 custom-fasilitas-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="fasilitas_custom[]" value="{{ $custom }}" id="custom_{{ $loop->index }}" checked>
                            <label class="form-check-label" for="custom_{{ $loop->index }}">
                                {{ $custom }}
                            </label>
                            <button type="button" class="btn btn-sm text-danger remove-custom-fasilitas" style="padding: 0 5px;">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const addBtn = document.getElementById('addCustomFasilitas');
                        const input = document.getElementById('customFasilitasInput');
                        const container = document.getElementById('fasilitasContainer');

                        addBtn.addEventListener('click', function() {
                            const val = input.value.trim();
                            if (val) {
                                const id = 'custom_' + Date.now();
                                const html = `
                                    <div class="col-md-4 mb-2 custom-fasilitas-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="fasilitas_custom[]" value="${val}" id="${id}" checked>
                                            <label class="form-check-label" for="${id}">
                                                ${val}
                                            </label>
                                            <button type="button" class="btn btn-sm text-danger remove-custom-fasilitas" style="padding: 0 5px;">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                container.insertAdjacentHTML('beforeend', html);
                                input.value = '';
                            }
                        });

                        // Handle remove button
                        container.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-custom-fasilitas') || e.target.closest('.remove-custom-fasilitas')) {
                                const item = e.target.closest('.custom-fasilitas-item');
                                if (item) {
                                    item.remove();
                                }
                            }
                        });
                    });
                </script>

                <hr>

                {{-- GAMBAR --}}
                <h5 class="mb-3 mt-3"><strong>Peraturan Kost</strong></h5>
                <div class="form-group mb-3">
                    <label>Tuliskan peraturan kost (Satu baris untuk satu aturan)</label>
                    <textarea name="peraturan_kost" class="form-control" rows="4" placeholder="1. Menjaga Kebersihan&#10;2. Dilarang Merokok di Kamar&#10;3. Tidak Membawa Hewan Peliharaan">{{ $kost->peraturan_kost }}</textarea>
                </div>

                <hr>

                <hr>
                <h5>Gambar Sebelumnya</h5>

                <div class="row">
                    @foreach ($kost->images as $img)
                    <div class="col-3 mt-3 text-center">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="img-fluid rounded mb-2">

                        <div>
                            <label class="text-danger small">
                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}">
                                Hapus Gambar
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="form-group mt-3">
                    <label>Upload Gambar Baru (opsional)</label>
                    <input type="file" name="images[]" multiple class="form-control">
                    <small class="text-muted">Jika upload gambar baru, gambar akan ditambahkan.</small>
                </div>


                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('kost.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection