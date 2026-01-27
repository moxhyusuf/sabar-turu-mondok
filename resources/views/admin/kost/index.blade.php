@extends('layout.app')

@section('title', 'Kost')
@section('page-title', 'Daftar Kost')

@section('content')

<section class="content">
    <div class="container-fluid">

        <div class="card">


            <div class="card-body">
                @php
                $role = auth()->user()->role;
                @endphp

                @if ($role === 'pemilik_dekost')
                <a href="{{ route('kost.create') }}" class="btn btn-primary btn-sm mb-3">
                    <i class="fas fa-plus"></i> Tambah Kost
                </a>
                @endif

                @php
                $role = auth()->user()->role;
                @endphp

                @if ($role === 'admin')
                <!-- FITUR CARI & CETAK -->
                <div class="d-flex justify-content-end align-items-center mb-3" style="gap: 12px;">

                    <!-- Form Cari -->
                    <form action="{{ route('kost.search') }}" method="GET" class="d-flex" style="width: 250px; ">
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            class="form-control form-control-sm"
                            placeholder="Cari kost...">
                        <button class="btn btn-secondary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <!-- Tombol Cetak -->
                    <a href="{{ route('kost.cetaklaporan', ['keyword' => request('keyword')]) }}"
                        target="_blank"
                        class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-print me-1"></i> Cetak
                    </a>

                </div>

                @endif


                @if ($role === 'admin')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Foto</th>
                                <th>Nama Kost</th>
                                <th>Pemilik</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Jumlah Kamar</th>
                                <th>NIB</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($kosts as $index => $kost)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>

                                {{-- FOTO --}}
                                <td>
                                    @if($kost->images->first())
                                    <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}"
                                        width="70" class="rounded">
                                    @else
                                    <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>

                                {{-- NAMA KOST --}}
                                <td>
                                    {{ $kost->nama_kost }}
                                    <span class="badge bg-success">{{ ucfirst($kost->jenis_kost) }}</span>

                                </td>

                                {{-- PEMILIK --}}
                                <td>
                                    {{ $kost->nama_pemilik }}<br>

                                </td>

                                {{-- KONTAK --}}
                                <td>

                                    {{ $kost->contact_person }}

                                </td>

                                {{-- ALAMAT --}}
                                <td>
                                    {{ $kost->alamat }}<br>

                                </td>

                                {{-- JUMLAH KAMAR --}}
                                <td class="text-center">
                                    {{ $kost->jumlah_kamar }}
                                </td>

                                {{-- NIB --}}
                                <td class="text-center">
                                    @if($kost->nib)
                                    {{ $kost->nib }}
                                    @else
                                    <span class="badge bg-secondary">Belum Ada</span>
                                    @endif
                                </td>

                                {{-- ACTION --}}
                                <td class="text-center">
                                    <a href="{{ route('kost.show', $kost->id) }}"
                                        class="btn btn-info btn-sm"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('kost.edit', $kost->id) }}"
                                        class="btn btn-warning btn-sm"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if ($role === 'admin')
                                    <form action="{{ route('kost.destroy', $kost->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada data kost.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Foto</th>
                                <th>Nama Kost</th>
                                <th>Pemilik</th>
                                <th>Kontak</th>
                                <th>Alamat</th>
                                <th>Jenis</th>
                                <th>Kamar</th>
                                <th>Harga</th>
                                <th>Fasilitas</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($kosts as $index => $kost)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>

                                {{-- FOTO THUMB --}}
                                <td>
                                    @if($kost->images->first())
                                    <img src="{{ asset('storage/' . $kost->images->first()->image_path) }}"
                                        width="70"
                                        class="rounded">
                                    @else
                                    <img src="{{ asset('no-image.png') }}" width="70" class="rounded">
                                    @endif
                                </td>

                                <td>{{ $kost->nama_kost }}</td>

                                <td>
                                    {{ $kost->nama_pemilik }} <br>

                                </td>

                                <td>

                                    {{ $kost->contact_person }}

                                </td>

                                <td>
                                    {{ $kost->alamat }} <br>

                                </td>

                                <td>{{ ucfirst($kost->jenis_kost) }}</td>

                                <td>{{ $kost->jumlah_kamar }}</td>
                                <td>{{ $kost->harga }}</td>

                                {{-- FASILITAS --}}
                                <td>
                                    @php
                                    $f = optional($kost->fasilitas);

                                    // daftar fasilitas sesuai urutan yang kamu mau
                                    $facilities = [
                                    'lahan_parkir' => 'Lahan Parkir',
                                    'pagar' => 'Pagar',
                                    'cctv' => 'CCTV',
                                    'ac_kipas' => 'AC / Kipas',
                                    'meteran_listrik' => 'Meteran Listrik',
                                    'wifi' => 'WiFi',
                                    'peraturan_penghuni' => 'Peraturan Penghuni',
                                    'penjaga' => 'Penjaga',
                                    'kasur' => 'Kasur',
                                    'bantal' => 'Bantal',
                                    'lemari' => 'Lemari',
                                    'guling' => 'Guling',
                                    'kursi' => 'Kursi',
                                    'meja' => 'Meja Belajar',
                                    'meja_rias' => 'Meja Rias',
                                    'mesin_cuci' => 'Mesin Cuci',
                                    'r_jemur' => 'Ruang Jemur',
                                    'dapur' => 'Dapur',
                                    ];

                                    // Filter hanya fasilitas bernilai 1
                                    $active = [];

                                    foreach ($facilities as $field => $label) {
                                    if ($f && $f->$field) {
                                    $active[] = $label;
                                    }
                                    }

                                    // Batasi hanya 5 fasilitas
                                    $active = array_slice($active, 0, 3);
                                    @endphp

                                    @foreach($active as $item)
                                    {{ $item }}<br>
                                    @endforeach
                                </td>



                                <td class="text-center">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('kost.edit', $kost->id) }}"
                                        class="btn btn-warning btn-sm d-inline-flex align-items-center justify-content-center me-1"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('kost.show', $kost->id) }}"
                                        class="btn btn-info btn-sm d-inline-flex align-items-center justify-content-center me-1"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Tombol Delete --}}
                                    @if ($role === 'admin')
                                    <form action="{{ route('kost.destroy', $kost->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm d-inline-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px; padding: 0;"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif

                                </td>



                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Belum ada data kost.</td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection
