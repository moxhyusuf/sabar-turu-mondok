@extends('layout.app')
@section('title', 'Data Booking')
@section('page-title', 'Data Booking')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Booking</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Nama Penyewa</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th>KTP</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $booking->penyewa->nama ?? '-' }}</td>
                            <td>{{ $booking->penyewa->email ?? '-' }}</td>
                            <td>{{ $booking->penyewa->no_hp ?? '-' }}</td>
                            <td>{{ $booking->penyewa->alamat ?? '-' }}</td>
                            <td>
                                @if($booking->penyewa && $booking->penyewa->ktp)
                                    <img src="{{ asset('storage/' . $booking->penyewa->ktp) }}" width="80" alt="KTP">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $booking->tanggal_masuk }}</td>
                            <td>{{ $booking->tanggal_keluar }}</td>
                            <td>
                                @if($booking->status == 'diproses' || $booking->status == 'pending')
                                    <span class="badge badge-warning">{{ $booking->status }}</span>
                                @elseif($booking->status == 'disetujui' || $booking->status == 'success' || $booking->status == 'aktif')
                                    <span class="badge badge-success">{{ $booking->status }}</span>
                                @elseif($booking->status == 'ditolak' || $booking->status == 'failed' || $booking->status == 'batal')
                                    <span class="badge badge-danger">{{ $booking->status }}</span>
                                @else
                                    {{ $booking->status }}
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 'aktif' || $booking->status == 'disetujui')
                                    <form action="{{ route('pemilik_dekost.booking.selesai', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-secondary btn-sm m-1" onclick="return confirm('Tandai selesai transaksi ini?')" title="Selesai"><i class="fas fa-flag-checkered"></i></button>
                                    </form>
                                @elseif($booking->status == 'batal')
                                    <form action="{{ route('pemilik_dekost.booking.destroy', $booking->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data booking yang batal ini?')" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data booking</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
