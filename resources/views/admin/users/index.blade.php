@extends('layout.app')

@section('title', 'User')
@section('page-title', 'Daftar User')

@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- ========== TABEL PETUGAS ========== --}}
                <div class="card">
                    <div class="card-header bg-seconday text-dark">
                        <h5 class="mb-2">Data Petugas Kecamatan</h5>
                    </div>

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif


                    <div class="card-body">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm mb-3">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($petugas as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <span class="badge bg-success">Approved</span>
                                        </td>
                                        <td class="text-center">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data petugas.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                {{-- ========== TABEL PEMILIK DEKOST ========== --}}
                <div class="card mt-4">
                    <div class="card-header bg-seconday text-dark">
                        <h5 class="mb-0">Data Pemilik Dekost</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Alamat</th>
                                        <th>Jabatan</th>
                                        <th>Bukti KTP</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pemilikDekost as $index => $user)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td class="text-center">
                                            @if($user->bukti_ktp)
                                            <a href="{{ asset('storage/' . $user->bukti_ktp) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $user->bukti_ktp) }}"
                                                    alt="Bukti KTP"
                                                    width="80"
                                                    class="rounded shadow-sm"
                                                    style="cursor: zoom-in;">
                                            </a>
                                            @else
                                            <small class="text-muted">Tidak ada</small>
                                            @endif
                                        </td>

                                        <td>
                                            @if($user->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                            @elseif($user->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                            @else
                                            <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>

                                        <td class="text-center">

                                            @if($user->status == 'pending')

                                            <!-- APPROVE -->
                                            <form action="{{ route('users.approve', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>

                                            <!-- REJECT -->
                                            <form action="{{ route('users.reject', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>

                                            @elseif($user->status == 'approved')

                                            <!-- NO ACTION -->
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                <i class="fas fa-ban"></i> No Action
                                            </button>

                                            @elseif($user->status == 'rejected')

                                            <!-- HAPUS KHUSUS REJECT -->
                                            <form action="{{ route('users.destroy', $user->id) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            @endif

                                        </td>


                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data pemilik dekost.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>
<script>
    setTimeout(function() {
        $(".alert").alert('close');
    }, 3000); // 3000 ms = 3 detik
</script>

@endsection
