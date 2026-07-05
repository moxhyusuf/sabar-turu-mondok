@extends('layouts_user.app')
@section('content')

<main class="main" style="background-color: #f8f9fa;">
    <div class="page-title dark-background" style="background-image: url('{{ asset('assets/img/travel/sabarturu.jpg') }}'); border-bottom-left-radius: 40px; border-bottom-right-radius: 40px; margin-bottom: -50px; padding-bottom: 80px;">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Transaksi Anda</h1>
            <p class="lead">Kelola pembayaran dan status pemesanan kost Anda.</p>
        </div>
    </div>

    <section class="section">
        <div class="container position-relative" style="z-index: 10;">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3 border-0 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-lg border-0 rounded-4 p-4 p-lg-5">
                        
                        <h4 class="fw-bold mb-4 d-flex align-items-center">
                            <i class="bi bi-receipt text-primary me-2"></i> Daftar Transaksi Kost
                        </h4>

                        @forelse($transaksis as $index => $tx)
                        <div class="card border border-light-subtle shadow-sm mb-4 rounded-4 hover-lift transition-all">
                            <div class="card-header bg-white border-bottom-0 pt-3 pb-0 px-4 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-muted small"><i class="bi bi-hash"></i> TX-{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="small text-muted"><i class="bi bi-clock me-1"></i> {{ $tx->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="card-body px-4 pb-4">
                                <div class="row align-items-center gy-3">
                                    <div class="col-md-5">
                                        <h5 class="fw-bold mb-1 text-dark">{{ $tx->kost->nama_kost ?? 'Kost Tidak Diketahui' }}</h5>
                                        <p class="text-muted small mb-0"><i class="bi bi-calendar-range me-1"></i> {{ \Carbon\Carbon::parse($tx->tanggal_masuk)->format('d M Y') }} — {{ \Carbon\Carbon::parse($tx->tanggal_keluar)->format('d M Y') }}</p>
                                        
                                        @if($tx->status_pembayaran == 'pending' || $tx->status_pembayaran == 'menunggu_verifikasi' || session('success'))
                                        <div class="mt-3 p-2 bg-light border rounded text-center position-relative">
                                            <span class="text-muted small d-block mb-1">Kode Booking Anda:</span>
                                            <span class="fs-4 fw-bold text-primary tracking-widest font-monospace user-select-all">{{ $tx->booking->kode_booking }}</span>
                                            <p class="text-danger small mb-0 mt-1 fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>Simpan atau screenshot kode ini!</p>
                                        </div>
                                        @endif

                                        @if($tx->status_pembayaran == 'pending')
                                        <div class="mt-3 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3">
                                            <h6 class="fw-bold text-primary mb-2"><i class="bi bi-bank me-2"></i>Informasi Pembayaran</h6>
                                            <p class="small mb-1 text-dark">Silakan transfer ke rekening berikut:</p>
                                            <div class="d-flex flex-column gap-1 mt-2">
                                                <div class="d-flex justify-content-between border-bottom pb-1 border-primary border-opacity-10">
                                                    <span class="text-muted small">Bank:</span>
                                                    <span class="fw-bold small">{{ $tx->kost->nama_bank ?? 'Menunggu Info Bank' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-1 border-primary border-opacity-10">
                                                    <span class="text-muted small">No. Rekening:</span>
                                                    <span class="fw-bold small">{{ $tx->kost->no_rekening ?? '-' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between border-bottom pb-1 border-primary border-opacity-10">
                                                    <span class="text-muted small">Atas Nama:</span>
                                                    <span class="fw-bold small">{{ $tx->kost->nama_pemilik ?? '-' }}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <span class="text-muted small">Total Tagihan:</span>
                                                    <span class="fw-bold small text-danger">Rp {{ number_format($tx->kost->harga, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                            <div class="mt-2 text-danger small">
                                                <i class="bi bi-info-circle-fill me-1"></i> Pemesanan akan dibatalkan otomatis jika tidak melakukan pembayaran dalam 1x24 jam.
                                            </div>
                                        </div>
                                        @endif
                                        
                                        @if($tx->status_pembayaran == 'batal')
                                        <div class="mt-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3 text-center">
                                            <h6 class="fw-bold text-danger mb-0"><i class="bi bi-x-circle me-2"></i>Pesanan sudah dibatalkan</h6>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex flex-column gap-2 border-start ps-3 border-opacity-25">
                                            <div>
                                                <span class="text-muted small d-block mb-1">Status Booking:</span>
                                                @if($tx->booking->status == 'aktif')
                                                    <span class="badge rounded-pill bg-success px-3 fw-normal py-2"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                                @elseif($tx->booking->status == 'batal')
                                                    <span class="badge rounded-pill bg-danger px-3 fw-normal py-2"><i class="bi bi-x-circle me-1"></i>Batal</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary px-3 fw-normal py-2"><i class="bi bi-info-circle me-1"></i>{{ ucfirst($tx->booking->status) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-muted small d-block mb-1">Status Pembayaran:</span>
                                                @if($tx->status_pembayaran == 'lunas')
                                                    <span class="badge rounded-pill bg-primary px-3 fw-normal py-2"><i class="bi bi-wallet-fill me-1"></i>Lunas</span>
                                                @elseif($tx->status_pembayaran == 'menunggu_verifikasi')
                                                    <span class="badge rounded-pill bg-info text-dark px-3 fw-normal py-2"><i class="bi bi-eye-fill me-1"></i>Verifikasi Bukti</span>
                                                @else
                                                    <span class="badge rounded-pill bg-secondary px-3 fw-normal py-2"><i class="bi bi-cash-stack me-1"></i>{{ ucfirst($tx->status_pembayaran) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end text-center mt-4 mt-md-0 d-flex flex-column justify-content-center">
                                        
                                        @if($tx->status_pembayaran == 'pending')
                                            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $tx->id }}">
                                                <i class="bi bi-cloud-arrow-up me-1"></i> Upload Bukti
                                            </button>
                                        @elseif($tx->status_pembayaran == 'menunggu_verifikasi')
                                            <div class="p-3 bg-light rounded-3 text-center">
                                                <div class="spinner-border text-primary spinner-border-sm mb-2" role="status"></div>
                                                <p class="small text-muted mb-0 lh-sm">Bukti sedang dicek<br>oleh Pemilik.</p>
                                            </div>
                                        @elseif($tx->status_pembayaran == 'lunas')
                                            <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 text-center border border-success border-opacity-25 mb-2">
                                                <i class="bi bi-shield-check fs-2 mb-1 d-block"></i>
                                                <p class="small fw-bold mb-0">Pembayaran Selesai</p>
                                            </div>
                                            <a href="{{ url('/transaksi/'.$tx->id.'/struk') }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 py-2 fw-bold w-100 mt-2">
                                                <i class="bi bi-printer me-1"></i> Cetak Struk
                                            </a>
                                        @elseif($tx->status_pembayaran == 'batal')
                                            <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3 text-center border border-danger border-opacity-25">
                                                <i class="bi bi-x-circle fs-2 mb-1 d-block"></i>
                                                <p class="small fw-bold mb-0">Dibatalkan</p>
                                            </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <img src="{{ asset('assets/img/travel/sabarturu.jpg') }}" class="img-fluid rounded-circle mb-3 shadow-sm" style="width:120px; height:120px; object-fit:cover; opacity:0.7;">
                            <h5 class="fw-bold text-muted">Belum ada transaksi</h4>
                            <p class="text-muted">Anda belum melakukan pesanan kamar kos.</p>
                            <a href="{{ url('/pemondokan') }}" class="btn btn-primary rounded-pill px-4 mt-2">Cari Kos Sekarang</a>
                        </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modals placed outside of any stacking context -->
@foreach($transaksis as $tx)
    @if($tx->status_pembayaran == 'pending')
    <div class="modal fade" id="uploadModal{{ $tx->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            @if(Auth::check() && Route::is('user.transaksi.index'))
                <form action="{{ route('user.transaksi.upload', $tx->id) }}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('guest.transaksi.upload', $tx->booking->kode_booking) }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf
                <div class="modal-content border-0 rounded-4 shadow">
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Upload Bukti Transfer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-start alert alert-info py-2 small mb-3 border-0">
                            <i class="bi bi-info-circle-fill me-1"></i> <strong>Penting:</strong> Pastikan Anda sudah mentransfer sesuai tagihan ke rekening pemilik. Gambar harus terlihat jelas (Format: JPG, PNG).
                        </div>
                        <input type="file" name="bukti_pembayaran" class="form-control form-control-lg bg-light" required accept="image/jpeg,image/png,image/jpg">
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Kirim Bukti</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif
@endforeach

<style>
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08)!important;
    }
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
</style>
@endsection
