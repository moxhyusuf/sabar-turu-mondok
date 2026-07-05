@extends('layout.app')

@section('title', 'Laporan Monitoring Rumah Kos')
@section('page-title', 'Laporan Monitoring')

@section('content')
<div class="container-fluid">
    <!-- Filter Card -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary font-weight-bold"><i class="fas fa-filter mr-2"></i> Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row align-items-end">
                <div class="col-md-3 mb-3">
                    <label for="from" class="form-label text-muted small font-weight-bold">DARI TANGGAL</label>
                    <input type="date" name="from" id="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="to" class="form-label text-muted small font-weight-bold">SAMPAI TANGGAL</label>
                    <input type="date" name="to" id="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="kelurahan" class="form-label text-muted small font-weight-bold">KELURAHAN</label>
                    <select name="kelurahan" id="kelurahan" class="form-control">
                        <option value="">Semua Kelurahan</option>
                        @foreach($listKelurahan as $kel)
                        <option value="{{ $kel }}" {{ request('kelurahan') == $kel ? 'selected' : '' }}>{{ $kel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="status_izin" class="form-label text-muted small font-weight-bold">STATUS IZIN</label>
                    <select name="status_izin" id="status_izin" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="berizin" {{ request('status_izin') == 'berizin' ? 'selected' : '' }}>Berizin</option>
                        <option value="belum_berizin" {{ request('status_izin') == 'belum_berizin' ? 'selected' : '' }}>Belum Berizin</option>
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
                    <h3>{{ $summary['total'] }}</h3>
                    <p>Total Rumah Kos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $summary['berizin'] }}</h3>
                    <p>Kos Berizin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $summary['belum_berizin'] }}</h3>
                    <p>Kos Belum Berizin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Export Buttons & Data Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary font-weight-bold"><i class="fas fa-table mr-2"></i> Detail Data Rumah Kos</h5>
            <div class="btn-group">
                <a href="{{ route('admin.reports.export.pdf', request()->all()) }}" class="btn btn-danger btn-sm shadow-sm">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('admin.reports.export.excel', request()->all()) }}" class="btn btn-success btn-sm shadow-sm">
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
                            <th>Nama Kos</th>
                            <th>Pemilik</th>
                            <th>Kelurahan</th>
                            <th>Status Perizinan</th>
                            <th>Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kosts as $index => $kost)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kost->nama_kost }}</td>
                            <td>{{ $kost->nama_pemilik }}</td>
                            <td>{{ $kost->kelurahan }}</td>
                            <td>
                                @if($kost->status_izin == 'berizin')
                                <span class="badge badge-success">Berizin</span>
                                @else
                                <span class="badge badge-warning">Belum Berizin</span>
                                @endif
                            </td>
                            <td>{{ $kost->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Report Type 1: Summary Per Kelurahan -->
            <div class="mt-5">
                <h6 class="font-weight-bold text-muted border-bottom pb-2">Jumlah Rumah Kos per Kelurahan</h6>
                <div class="row mt-3">
                    @foreach($perKelurahan as $kel => $count)
                    <div class="col-md-3 col-6 mb-3">
                        <div class="p-3 border rounded bg-light text-center shadow-sm">
                            <h4 class="mb-0 font-weight-bold">{{ $count }}</h4>
                            <span class="text-muted small">{{ $kel }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
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

    .small-box:hover {
        transform: translateY(-5px);
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