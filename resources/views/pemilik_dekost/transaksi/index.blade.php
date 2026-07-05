@extends('layout.app')
@section('title', 'Data Transaksi')
@section('page-title', 'Data Transaksi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
            <div class="card-header bg-white border-bottom py-3" style="border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="card-title mb-0 fw-bold"><i class="fas fa-receipt text-primary mr-2"></i> Daftar Transaksi</h3>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pemilik_dekost.transaksi.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Transaksi
                    </a>
                    <div class="card-tools m-0">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" id="tableSearch" class="form-control bg-light border-0" placeholder="Cari transaksi..." style="border-radius: 20px 0 0 20px;">
                            <div class="input-group-append">
                                <span class="input-group-text bg-light border-0" style="border-radius: 0 20px 20px 0;">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover text-center align-middle mb-0" id="transaksiTable">
                    <thead class="bg-light text-muted">
                        <tr>
                            <th class="border-top-0 border-bottom-0 py-3">Nama Penyewa</th>
                            <!-- <th class="border-top-0 border-bottom-0 py-3">Nama Kost</th> -->
                            <th class="border-top-0 border-bottom-0 py-3">Tanggal Masuk</th>
                            <th class="border-top-0 border-bottom-0 py-3">Tanggal Keluar</th>
                            <th class="border-top-0 border-bottom-0 py-3">Harga Kos</th>
                            <th class="border-top-0 border-bottom-0 py-3">Metode</th>
                            <th class="border-top-0 border-bottom-0 py-3">Status Pembayaran</th>
                            <th class="border-top-0 border-bottom-0 py-3">Status</th>
                            <th class="border-top-0 border-bottom-0 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $transaksi)
                        <tr class="border-bottom">
                            <td class="fw-bold">{{ $transaksi->booking->penyewa->nama ?? '-' }}</td>
                            <!-- <td>{{ $transaksi->kost->nama_kost ?? '-' }}</td> -->
                            <td class="text-muted"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d M Y') }}</td>
                            <td class="text-muted"><i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_keluar)->format('d M Y') }}</td>
                            <td class="fw-bold text-dark">Rp {{ number_format($transaksi->kost->harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @if($transaksi->metode_pembayaran == 'cash')
                                <span class="badge badge-light shadow-none text-muted border py-2 px-3 rounded-pill">Cash</span>
                                @else
                                <span class="badge badge-light shadow-none text-muted border py-2 px-3 rounded-pill">Transfer</span>
                                @endif
                            </td>

                            {{-- Status Pembayaran --}}
                            <td>
                                @if($transaksi->status_pembayaran == 'lunas')
                                <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-wallet mr-1"></i> Lunas</span>
                                @elseif($transaksi->status_pembayaran == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-clock mr-1"></i> Pending</span>
                                @elseif($transaksi->status_pembayaran == 'menunggu_verifikasi')
                                <span class="badge bg-info text-white px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-search-dollar mr-1"></i> Verifikasi</span>
                                @elseif($transaksi->status_pembayaran == 'ditolak')
                                <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-times-circle mr-1"></i> Ditolak</span>
                                @else
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ ucfirst($transaksi->status_pembayaran) }}</span>
                                @endif
                            </td>

                            {{-- Status Booking/Transaksi --}}
                            <td>
                                @if($transaksi->status == 'aktif' || $transaksi->status == 'disetujui')
                                <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                                @elseif($transaksi->status == 'selesai')
                                <span class="badge bg-secondary px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-flag-checkered mr-1"></i> Selesai</span>
                                @elseif($transaksi->status == 'pending' || $transaksi->status == 'diproses')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-hourglass-half mr-1"></i> Pending</span>
                                @elseif($transaksi->status == 'ditolak' || $transaksi->status == 'batal')
                                <span class="badge bg-danger px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-times mr-1"></i> Ditolak</span>
                                @else
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ ucfirst($transaksi->status) }}</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-1">
                                    {{-- Tombol Lihat Bukti - Selalu Tampil jika ada filenya --}}
                                    @if($transaksi->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $transaksi->bukti_pembayaran) }}" target="_blank" class="btn btn-info btn-sm rounded-circle shadow-sm mx-1" style="width:32px; height:32px; line-height:1.5;" title="Lihat Bukti">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endif

                                    @if($transaksi->status_pembayaran == 'menunggu_verifikasi')
                                    <form action="{{ route('pemilik_dekost.transaksi.verify', ['id' => $transaksi->id, 'action' => 'approve']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm rounded-circle shadow-sm mx-1" style="width:32px; height:32px; line-height:1.5;" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('pemilik_dekost.transaksi.verify', ['id' => $transaksi->id, 'action' => 'reject']) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-danger btn-sm rounded-circle shadow-sm mx-1" style="width:32px; height:32px; line-height:1.5;" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    @elseif($transaksi->status_pembayaran == 'lunas')
                                    <span class="text-success small fw-bold"><i class="fas fa-check-double mr-1"></i> Terverifikasi</span>
                                    @else
                                    <span class="text-muted small">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 text-light"></i>
                                    <p class="mb-0">Belum ada data transaksi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('tableSearch');
        searchInput.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#transaksiTable tbody tr');

            rows.forEach(row => {
                // Ignore the "empty data" row
                if (row.cells.length === 1) return;

                let text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection