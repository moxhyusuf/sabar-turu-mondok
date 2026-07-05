@extends('layout.app')

@section('title', 'Laporan Monitoring Pemilik Kos')
@section('page-title', 'Laporan Monitoring')

@section('content')
<div class="container-fluid">
    <!-- Filter Card -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary font-weight-bold"><i class="fas fa-filter mr-2"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pemilik_dekost.reports.index') }}" method="GET" class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="from" class="form-label text-muted small font-weight-bold">DARI TANGGAL</label>
                    <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="to" class="form-label text-muted small font-weight-bold">SAMPAI TANGGAL</label>
                    <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="status" class="form-label text-muted small font-weight-bold">STATUS</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-search"></i> Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Section -->
    <!-- <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $summary['total_kamar'] }}</h3>
                    <p>Total Kamar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $summary['kamar_terisi'] }}</h3>
                    <p>Kamar Terisi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $summary['kamar_kosong'] }}</h3>
                    <p>Kamar Kosong</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Penghuni Summary -->
    <div class="row mt-2">
        <div class="col-lg-6 col-12">
            <div class="info-box shadow-sm border-0">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text font-weight-bold">Penghuni Aktif</span>
                    <span class="info-box-number h4 mb-0">{{ $summary['penghuni_aktif'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="info-box shadow-sm border-0">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user-minus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text font-weight-bold">Penghuni Keluar</span>
                    <span class="info-box-number h4 mb-0">{{ $summary['penghuni_keluar'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons & Data Table -->
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary font-weight-bold"><i class="fas fa-history mr-2"></i> Riwayat Booking & Transaksi</h5>
            <div class="btn-group">
                <a href="{{ route('pemilik_dekost.reports.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm shadow-sm" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('pemilik_dekost.reports.export.excel', request()->all()) }}" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Penyewa</th>
                            <th>Kost</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $t->booking->penyewa->nama ?? 'N/A' }}</td>
                            <td>{{ $t->kost->nama_kost ?? 'N/A' }}</td>
                            <td>{{ $t->booking->tanggal_masuk ?? 'N/A' }}</td>
                            <td>{{ $t->tanggal_keluar ?? 'N/A' }}</td>
                            <td>
                                @if($t->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                                @elseif($t->status == 'selesai')
                                <span class="badge badge-info">Selesai</span>
                                @else
                                <span class="badge badge-danger">Batal</span>
                                @endif
                            </td>
                            <td>{{ $t->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Data transaksi tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .small-box {
        border-radius: 12px;
        transition: transform 0.2s;
    }

    .info-box {
        border-radius: 12px;
    }

    .card {
        border-radius: 12px;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.8em;
        border-radius: 6px;
    }
</style>
@endpush