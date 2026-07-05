@extends('layout.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- MARQUEE (MUNCUL UNTUK SEMUA USER) --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="marquee-container">
            <div class="marquee-text">
                <i class="fas fa-bullhorn me-2"></i>
                SELAMAT DATANG,
                <span class="highlight-name">
                    {{ strtoupper(auth()->user()->nama) }}
                </span> DI APLIKASI SABAR-TURU-MONDOK KECAMATAN KANIGARAN KOTA PROBOLINGGO
            </div>
        </div>
    </div>
</div>

{{-- JIKA ADMIN → TAMPIL SEMUA --}}
@auth
@if(auth()->user()->role === 'admin')

<div class="row">

    {{-- Kanigaran --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $dataKelurahan['kanigaran'] }}</h3>
                <p>Kanigaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Curahgrinting --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $dataKelurahan['curahgrinting'] }}</h3>
                <p>Curahgrinting</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Kebonsari Wetan --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $dataKelurahan['kebonsari_wetan'] }}</h3>
                <p>Kebonsari Wetan</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Kebonsari Kulon --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $dataKelurahan['kebonsari_kulon'] }}</h3>
                <p>Kebonsari Kulon</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Sukoharjo --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $dataKelurahan['sukoharjo'] }}</h3>
                <p>Sukoharjo</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- Tisnonegaran --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $dataKelurahan['tisnonegaran'] }}</h3>
                <p>Tisnonegaran</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
    </div>

    {{-- TOTAL --}}
    <div class="col-lg-6 col-12">
        <div class="small-box bg-dark">
            <div class="inner text-center">
                <h2>{{ $totalKost }}</h2>
                <p>Total Kost di Kecamatan Kanigaran</p>
            </div>
            <div class="icon"> <i class="ion ion-stats-bars"></i> </div>
        </div>
    </div>

</div>

@elseif(auth()->user()->role === 'pemilik_dekost')

<div class="row">
    {{-- Jumlah Penghuni Aktif --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $statsPemilik['jumlah_penghuni'] }}</h3>
                <p>Penghuni Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('pemilik_dekost.reports.index', ['status' => 'aktif']) }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Jumlah Penghuni Keluar --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary shadow-sm">
            <div class="inner">
                <h3>{{ $statsPemilik['penghuni_keluar'] }}</h3>
                <p>Penghuni Keluar</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-minus"></i>
            </div>
            <a href="{{ route('pemilik_dekost.reports.index', ['status' => 'selesai']) }}" class="small-box-footer">
                Lihat Detail <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    {{-- Kamar Terisi --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $statsPemilik['kamar_terisi'] }}</h3>
                <p>Kamar Terisi</p>
            </div>
            <div class="icon">
                <i class="fas fa-bed"></i>
            </div>
            <div class="small-box-footer" style="height: 30px;"></div>
        </div>
    </div>

    {{-- Kamar Tersedia --}}
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3>{{ $statsPemilik['kamar_tersedia'] }}</h3>
                <p>Sisa Kamar</p>
            </div>
            <div class="icon">
                <i class="fas fa-door-open"></i>
            </div>
            <div class="small-box-footer" style="height: 30px;"></div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Chart Statistik Bulanan --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-primary">
                    <i class="fas fa-chart-line mr-1"></i> Statistik Hunian {{ now()->year }}
                </h3>
            </div>
            <div class="card-body">
                <div class="chart">
                    <canvas id="monthlyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Transaksi --}}
    <div class="col-lg-4">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $statsPemilik['total_transaksi'] }}</h3>
                <p>Total Transaksi Lunas</p>
            </div>
            <div class="icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <a href="{{ route('pemilik_dekost.transaksi.index') }}" class="small-box-footer">
                Semua Transaksi <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        {{-- Pending Activities Summary --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Booking Pending
                        <span class="badge badge-warning badge-pill">{{ $recentBookings->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pembayaran Pending
                        <span class="badge badge-danger badge-pill">{{ $recentPayments->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Recent Bookings --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-calendar-alt mr-1"></i> Booking Pending Terbaru
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-valign-middle mb-0">
                        <thead>
                            <tr>
                                <th>Penyewa</th>
                                <th>Kost</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $booking->penyewa->nama ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $booking->created_at->diffForHumans() }}</small>
                                </td>
                                <td>{{ $booking->kost->nama_kost ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('pemilik_dekost.booking.index') }}" class="btn btn-xs btn-primary">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Tidak ada booking pending</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-credit-card mr-1"></i> Pembayaran Pending Terbaru
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-valign-middle mb-0">
                        <thead>
                            <tr>
                                <th>Penyewa</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                            <tr>
                                <td>
                                    <div class="font-weight-bold text-dark">{{ $payment->booking->penyewa->nama ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                                </td>
                                <td>Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('pemilik_dekost.transaksi.index') }}" class="btn btn-xs btn-success">
                                        Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-3 text-muted">Tidak ada pembayaran pending</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        var ctx = document.getElementById('monthlyChart').getContext('2d');
        var monthlyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Penghuni Aktif',
                    backgroundColor: '#17a2b8',
                    borderColor: '#17a2b8',
                    data: @json(array_values($statsBulanan['aktif']))
                }, {
                    label: 'Penghuni Keluar',
                    backgroundColor: '#6c757d',
                    borderColor: '#6c757d',
                    data: @json(array_values($statsBulanan['keluar']))
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true,
                    position: 'top'
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: true,
                            color: '#f3f3f3',
                            zeroLineColor: '#ccc'
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    });
</script>
@endpush

@else
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning shadow-sm border-0">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Halo <strong>{{ auth()->user()->nama }}</strong>, akun Anda memiliki role <strong>{{ auth()->user()->role }}</strong>. 
            Saat ini belum ada tampilan dashboard khusus untuk role ini.
        </div>
    </div>
</div>
@endif
@endauth

@endsection
